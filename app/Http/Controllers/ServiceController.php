<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('name', 'asc')->get();
        return view('services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:services,name',
            'base_price' => 'required|numeric|min:0',
        ]);

        Service::create([
            'name' => $request->name,
            'base_price' => $request->base_price,
        ]);

        return redirect()->route('services.index')->with('success', 'Jasa berhasil ditambahkan!');
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:services,name,' . $service->id,
            'base_price' => 'required|numeric|min:0',
        ]);

        $service->update([
            'name' => $request->name,
            'base_price' => $request->base_price,
        ]);

        return redirect()->route('services.index')->with('success', 'Jasa berhasil diperbarui!');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Jasa berhasil dihapus!');
    }
}
