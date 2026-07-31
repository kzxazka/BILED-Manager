<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Expense;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Calculate totals from completed projects
        $totalRevenue = Project::where('status', 'completed')->sum('total_amount');
        $totalHpp = Project::where('status', 'completed')->sum('total_hpp');
        $totalExpenses = Expense::sum('amount');
        $netProfit = $totalRevenue - $totalHpp - $totalExpenses;

        // Fetch products with stock at or below minimum stock threshold
        $lowStockProducts = Product::whereColumn('stock', '<=', 'min_stock')
            ->with('category')
            ->get();

        // Fetch recent projects
        $recentProjects = Project::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalRevenue',
            'totalHpp',
            'totalExpenses',
            'netProfit',
            'lowStockProducts',
            'recentProjects'
        ));
    }
}
