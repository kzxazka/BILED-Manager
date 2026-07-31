<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_code')->unique();
            $table->string('customer_name');
            $table->string('license_plate')->nullable();
            $table->decimal('labor_fee', 12, 2)->default(0.00);
            $table->decimal('total_amount', 12, 2);
            $table->decimal('total_hpp', 12, 2);
            $table->decimal('net_profit', 12, 2);
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
