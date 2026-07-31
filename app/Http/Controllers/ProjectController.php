<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectItem;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query = Project::orderBy('created_at', 'desc');

        if ($status && in_array($status, ['pending', 'completed', 'cancelled'])) {
            $query->where('status', $status);
        }

        $projects = $query->get();
        return view('projects.index', compact('projects', 'status'));
    }

    public function create()
    {
        $products = Product::with('category')->orderBy('name', 'asc')->get();
        $services = Service::orderBy('name', 'asc')->get();
        return view('projects.create', compact('products', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'license_plate' => 'nullable|string|max:50',
            'labor_fee' => 'required|numeric|min:0',
            'status' => 'required|string|in:pending,completed,cancelled',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Generate Invoice Code: INV-YYYYMM-XXXX
        $prefix = 'INV-' . date('Ym') . '-';
        $lastProject = Project::where('invoice_code', 'like', $prefix . '%')
            ->orderBy('invoice_code', 'desc')
            ->first();

        if ($lastProject) {
            $lastSequence = intval(substr($lastProject->invoice_code, -4));
            $sequence = str_pad($lastSequence + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $sequence = '0001';
        }
        $invoiceCode = $prefix . $sequence;

        $laborFee = floatval($request->labor_fee);
        $status = $request->status;

        DB::transaction(function () use ($request, $invoiceCode, $laborFee, $status) {
            $totalHpp = 0;
            $totalMaterialsSell = 0;
            $itemsData = [];

            // 1. Process items and calculate totals
            foreach ($request->items as $itemIndex => $item) {
                $product = Product::lockForUpdate()->find($item['product_id']);
                $quantity = intval($item['quantity']);

                // If completed, validate stock availability
                if ($status === 'completed') {
                    if ($product->stock < $quantity) {
                        throw ValidationException::withMessages([
                            'items' => "Stok untuk produk '{$product->name}' tidak mencukupi. (Sisa: {$product->stock}, Diminta: {$quantity})"
                        ]);
                    }
                }

                $hppAtSale = floatval($product->hpp_price);
                $sellPriceAtSale = floatval($product->sell_price);
                $subtotal = $quantity * $sellPriceAtSale;

                $totalHpp += $quantity * $hppAtSale;
                $totalMaterialsSell += $subtotal;

                $itemsData[] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'hpp_at_sale' => $hppAtSale,
                    'sell_price_at_sale' => $sellPriceAtSale,
                    'subtotal' => $subtotal,
                    'product_model' => $product // Keep instance to update stock later
                ];
            }

            $totalAmount = $totalMaterialsSell + $laborFee;
            $netProfit = $totalAmount - $totalHpp;

            // 2. Create Project
            $project = Project::create([
                'invoice_code' => $invoiceCode,
                'customer_name' => $request->customer_name,
                'license_plate' => $request->license_plate,
                'labor_fee' => $laborFee,
                'total_amount' => $totalAmount,
                'total_hpp' => $totalHpp,
                'net_profit' => $netProfit,
                'status' => $status
            ]);

            // 3. Create Project Items & Deduct Stock
            foreach ($itemsData as $itemData) {
                ProjectItem::create([
                    'project_id' => $project->id,
                    'product_id' => $itemData['product_id'],
                    'quantity' => $itemData['quantity'],
                    'hpp_at_sale' => $itemData['hpp_at_sale'],
                    'sell_price_at_sale' => $itemData['sell_price_at_sale'],
                    'subtotal' => $itemData['subtotal']
                ]);

                if ($status === 'completed') {
                    $product = $itemData['product_model'];
                    $product->stock -= $itemData['quantity'];
                    $product->save();
                }
            }
        });

        return redirect()->route('projects.index')->with('success', "Proyek {$invoiceCode} berhasil ditambahkan!");
    }

    public function show(Project $project)
    {
        $project->load('projectItems.product.category');
        return view('projects.show', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'status' => 'required|string|in:pending,completed,cancelled',
        ]);

        $oldStatus = $project->status;
        $newStatus = $request->status;

        if ($oldStatus === $newStatus) {
            return redirect()->route('projects.show', $project->id)->with('info', 'Status proyek tidak berubah.');
        }

        DB::transaction(function () use ($project, $oldStatus, $newStatus) {
            // Transition to completed -> deduct stock
            if ($newStatus === 'completed') {
                foreach ($project->projectItems as $item) {
                    $product = Product::lockForUpdate()->find($item->product_id);
                    if ($product->stock < $item->quantity) {
                        throw ValidationException::withMessages([
                            'status' => "Gagal mengubah status. Stok produk '{$product->name}' tidak mencukupi. (Sisa: {$product->stock}, Diminta: {$item->quantity})"
                        ]);
                    }
                    $product->stock -= $item->quantity;
                    $product->save();
                }
            }

            // Transition from completed to something else -> restore stock
            if ($oldStatus === 'completed' && ($newStatus === 'pending' || $newStatus === 'cancelled')) {
                foreach ($project->projectItems as $item) {
                    $product = Product::lockForUpdate()->find($item->product_id);
                    $product->stock += $item->quantity;
                    $product->save();
                }
            }

            $project->status = $newStatus;
            $project->save();
        });

        return redirect()->route('projects.show', $project->id)->with('success', 'Status proyek berhasil diperbarui!');
    }

    public function destroy(Project $project)
    {
        DB::transaction(function () use ($project) {
            // Restore stock if deleting a completed project
            if ($project->status === 'completed') {
                foreach ($project->projectItems as $item) {
                    $product = Product::lockForUpdate()->find($item->product_id);
                    if ($product) {
                        $product->stock += $item->quantity;
                        $product->save();
                    }
                }
            }
            $project->delete();
        });

        return redirect()->route('projects.index')->with('success', 'Proyek berhasil dihapus.');
    }
}
