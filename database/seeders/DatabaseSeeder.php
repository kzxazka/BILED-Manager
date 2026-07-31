<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use App\Models\Project;
use App\Models\ProjectItem;
use App\Models\Expense;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Wipe/Reset Logic: Truncate existing data to start fresh.
        // This acts as a wipe flag for local testing.
        Schema::disableForeignKeyConstraints();
        
        User::truncate();
        Category::truncate();
        Product::truncate();
        Service::truncate();
        Project::truncate();
        ProjectItem::truncate();
        Expense::truncate();
        
        Schema::enableForeignKeyConstraints();

        // 2. Seed Default User
        User::factory()->create([
            'name' => 'Owner Bengkel',
            'email' => 'owner@biledmanager.com',
            'password' => bcrypt('password123'),
        ]);

        // 3. Seed Categories
        $lenses = Category::create(['name' => 'Lenses']);
        $shrouds = Category::create(['name' => 'Shrouds']);
        $demonEyes = Category::create(['name' => 'Demon Eyes']);
        $wiring = Category::create(['name' => 'Wiring Harness']);
        $consumables = Category::create(['name' => 'Consumables']);

        // 4. Seed Products
        // Category: Lenses
        $biledGen1 = Product::create([
            'category_id' => $lenses->id,
            'name' => 'BILED Projector Gen 1 (3.0 inch)',
            'hpp_price' => 450000,
            'sell_price' => 750000,
            'stock' => 10,
            'min_stock' => 2,
        ]);
        $biledGen2 = Product::create([
            'category_id' => $lenses->id,
            'name' => 'BILED Projector Gen 2 (2.5 inch)',
            'hpp_price' => 550000,
            'sell_price' => 900000,
            'stock' => 8,
            'min_stock' => 2,
        ]);

        // Category: Shrouds
        $bmwShroud = Product::create([
            'category_id' => $shrouds->id,
            'name' => 'BMW Style Shroud 3.0 inch',
            'hpp_price' => 750000 / 10, // Cost for bulk, say 75,000 each
            'sell_price' => 150000,
            'stock' => 12,
            'min_stock' => 4,
        ]);
        $turbineShroud = Product::create([
            'category_id' => $shrouds->id,
            'name' => 'Classic Turbine Shroud 2.5 inch',
            'hpp_price' => 60000,
            'sell_price' => 120000,
            'stock' => 6,
            'min_stock' => 2,
        ]);

        // Category: Demon Eyes
        $rgbDemon = Product::create([
            'category_id' => $demonEyes->id,
            'name' => 'RGB Bluetooth Demon Eyes',
            'hpp_price' => 100000,
            'sell_price' => 200000,
            'stock' => 5,
            'min_stock' => 2,
        ]);
        $redDemon = Product::create([
            'category_id' => $demonEyes->id,
            'name' => 'Single Color Demon Eyes Red',
            'hpp_price' => 40000,
            'sell_price' => 80000,
            'stock' => 15,
            'min_stock' => 4,
        ]);

        // Category: Wiring Harness
        $relayH4 = Product::create([
            'category_id' => $wiring->id,
            'name' => 'Relay Harness Controller H4',
            'hpp_price' => 50000,
            'sell_price' => 100000,
            'stock' => 7,
            'min_stock' => 2,
        ]);

        // Category: Consumables
        $butylGlue = Product::create([
            'category_id' => $consumables->id,
            'name' => 'Retrofit Butyl Rubber Glue',
            'hpp_price' => 30000,
            'sell_price' => 60000,
            'stock' => 1, // Triggers low stock alert
            'min_stock' => 2,
        ]);

        // 5. Seed Services
        Service::create([
            'name' => 'Headlamp Opening & Cleaning',
            'base_price' => 250000,
        ]);
        Service::create([
            'name' => 'Full Retrofit Labor (Standard Dual Lens)',
            'base_price' => 750000,
        ]);
        Service::create([
            'name' => 'Wiring Customization & Tuning',
            'base_price' => 150000,
        ]);

        // 6. Seed Projects & Project Items
        // Project 1 (Completed): 2x BILED Gen 1, 2x BMW Shroud, 2x RGB Demon, 1x Relay H4
        $project1 = Project::create([
            'invoice_code' => 'INV-202607-0001',
            'customer_name' => 'Budi Santoso',
            'license_plate' => 'B 1234 ABC',
            'labor_fee' => 1000000,
            'total_amount' => 3300000,
            'total_hpp' => 1300000,
            'net_profit' => 2000000,
            'status' => 'completed',
            'created_at' => now()->subDays(5),
            'updated_at' => now()->subDays(5),
        ]);

        ProjectItem::create([
            'project_id' => $project1->id,
            'product_id' => $biledGen1->id,
            'quantity' => 2,
            'hpp_at_sale' => 45000, // Wait, hpp_price is 450,000. Let's make sure it matches the product table.
            'sell_price_at_sale' => 750000,
            'subtotal' => 1500000,
        ]);
        // Fix project1 item 1 hpp_at_sale -> 450000.
        // Let's rewrite the item creation correctly.
        $project1Items = [
            [
                'product_id' => $biledGen1->id,
                'quantity' => 2,
                'hpp_at_sale' => 450000,
                'sell_price_at_sale' => 750000,
                'subtotal' => 1500000,
            ],
            [
                'product_id' => $bmwShroud->id,
                'quantity' => 2,
                'hpp_at_sale' => 75000,
                'sell_price_at_sale' => 150000,
                'subtotal' => 300000,
            ],
            [
                'product_id' => $rgbDemon->id,
                'quantity' => 2,
                'hpp_at_sale' => 100000,
                'sell_price_at_sale' => 200000,
                'subtotal' => 400000,
            ],
            [
                'product_id' => $relayH4->id,
                'quantity' => 1,
                'hpp_at_sale' => 50000,
                'sell_price_at_sale' => 100000,
                'subtotal' => 100000,
            ],
        ];

        foreach ($project1Items as $item) {
            ProjectItem::create(array_merge($item, ['project_id' => $project1->id]));
        }

        // Project 2 (Pending): 2x BILED Gen 2, 2x Turbine Shroud
        $project2 = Project::create([
            'invoice_code' => 'INV-202607-0002',
            'customer_name' => 'Andi Wijaya',
            'license_plate' => 'D 9999 XYZ',
            'labor_fee' => 900000,
            'total_amount' => 2940000,
            'total_hpp' => 1220000,
            'net_profit' => 1720000,
            'status' => 'pending',
            'created_at' => now()->subDays(2),
            'updated_at' => now()->subDays(2),
        ]);

        $project2Items = [
            [
                'product_id' => $biledGen2->id,
                'quantity' => 2,
                'hpp_at_sale' => 550000,
                'sell_price_at_sale' => 900000,
                'subtotal' => 1800000,
            ],
            [
                'product_id' => $turbineShroud->id,
                'quantity' => 2,
                'hpp_at_sale' => 60000,
                'sell_price_at_sale' => 120000,
                'subtotal' => 240000,
            ],
        ];

        foreach ($project2Items as $item) {
            ProjectItem::create(array_merge($item, ['project_id' => $project2->id]));
        }

        // Project 3 (Cancelled): 2x Red Demon
        $project3 = Project::create([
            'invoice_code' => 'INV-202607-0003',
            'customer_name' => 'Citra Dewi',
            'license_plate' => 'L 5678 AA',
            'labor_fee' => 250000,
            'total_amount' => 410000,
            'total_hpp' => 80000,
            'net_profit' => 330000,
            'status' => 'cancelled',
            'created_at' => now()->subDay(),
            'updated_at' => now()->subDay(),
        ]);

        ProjectItem::create([
            'project_id' => $project3->id,
            'product_id' => $redDemon->id,
            'quantity' => 2,
            'hpp_at_sale' => 40000,
            'sell_price_at_sale' => 80000,
            'subtotal' => 160000,
        ]);

        // 7. Seed Expenses
        Expense::create([
            'description' => 'Listrik Bengkel Juli 2026',
            'amount' => 350000,
            'expense_date' => '2026-07-15',
        ]);
        Expense::create([
            'description' => 'Pembelian Solder Baru',
            'amount' => 120000,
            'expense_date' => '2026-07-20',
        ]);
        Expense::create([
            'description' => 'Sewa Ruko Bulanan (Proporsional)',
            'amount' => 1500000,
            'expense_date' => '2026-07-01',
        ]);
    }
}
