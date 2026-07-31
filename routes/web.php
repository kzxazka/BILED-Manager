<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ExpenseController;

// Dashboard Route
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Settings & System Reset Routes
Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
Route::post('/settings/purge', [SettingsController::class, 'purge'])->name('settings.purge');

// Master Data CRUD Resources
Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('services', ServiceController::class);

// Core Transactional Modules
Route::resource('projects', ProjectController::class);
Route::resource('expenses', ExpenseController::class)->only(['index', 'store', 'destroy']);
