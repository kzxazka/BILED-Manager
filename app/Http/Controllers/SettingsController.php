<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use App\Models\Project;
use App\Models\ProjectItem;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings');
    }

    public function purge(Request $request)
    {
        $request->validate([
            'confirm_purge' => 'required|string|in:HAPUS',
        ]);

        Schema::disableForeignKeyConstraints();

        Category::truncate();
        Product::truncate();
        Service::truncate();
        Project::truncate();
        ProjectItem::truncate();
        Expense::truncate();

        Schema::enableForeignKeyConstraints();

        return redirect()->route('settings')->with('success', 'Seluruh data berhasil dikosongkan! Sistem kini dalam keadaan bersih.');
    }
}
