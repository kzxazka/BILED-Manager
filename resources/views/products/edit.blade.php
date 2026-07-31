@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div>
        <a href="{{ route('products.index') }}" class="text-xs text-[#00F0FF] font-medium flex items-center space-x-1 mb-1 hover:underline">
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span>Daftar Stok</span>
        </a>
        <h2 class="text-xl font-bold text-zinc-100">Edit Produk</h2>
        <p class="text-xs text-zinc-400">Perbarui rincian produk "{{ $product->name }}"</p>
    </div>

    <!-- Form Card -->
    <div class="bg-zinc-900/90 rounded-2xl p-5 border border-zinc-800 shadow-sm">
        <form action="{{ route('products.update', $product->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Category -->
            <div class="space-y-1">
                <label for="category_id" class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wide">Kategori</label>
                <select name="category_id" id="category_id" required
                        class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-3 py-3 text-xs text-zinc-200 focus:outline-none focus:border-[#00F0FF]/50 transition-colors">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Name -->
            <div class="space-y-1">
                <label for="name" class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wide">Nama Produk</label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                       class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-3 py-3 text-xs text-zinc-200 focus:outline-none focus:border-[#00F0FF]/50 transition-colors">
            </div>

            <!-- Prices Row -->
            <div class="grid grid-cols-2 gap-4">
                <!-- HPP Price -->
                <div class="space-y-1">
                    <label for="hpp_price" class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wide">Harga Modal (HPP)</label>
                    <input type="number" name="hpp_price" id="hpp_price" value="{{ old('hpp_price', intval($product->hpp_price)) }}" required min="0"
                           class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-3 py-3 text-xs text-zinc-200 focus:outline-none focus:border-[#00F0FF]/50 transition-colors">
                </div>

                <!-- Selling Price -->
                <div class="space-y-1">
                    <label for="sell_price" class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wide">Harga Jual (Retail)</label>
                    <input type="number" name="sell_price" id="sell_price" value="{{ old('sell_price', intval($product->sell_price)) }}" required min="0"
                           class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-3 py-3 text-xs text-zinc-200 focus:outline-none focus:border-[#00F0FF]/50 transition-colors">
                </div>
            </div>

            <!-- Stock Row -->
            <div class="grid grid-cols-2 gap-4">
                <!-- Stock -->
                <div class="space-y-1">
                    <label for="stock" class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wide">Jumlah Stok</label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" required min="0"
                           class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-3 py-3 text-xs text-zinc-200 focus:outline-none focus:border-[#00F0FF]/50 transition-colors">
                </div>

                <!-- Min Stock -->
                <div class="space-y-1">
                    <label for="min_stock" class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wide">Batas Stok Minim</label>
                    <input type="number" name="min_stock" id="min_stock" value="{{ old('min_stock', $product->min_stock) }}" required min="0"
                           class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-3 py-3 text-xs text-zinc-200 focus:outline-none focus:border-[#00F0FF]/50 transition-colors">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-3 pt-2">
                <a href="{{ route('products.index') }}" 
                   class="flex-1 py-3 bg-zinc-800 hover:bg-zinc-750 active:bg-zinc-700 text-zinc-300 font-semibold text-xs rounded-xl text-center shadow-sm transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="flex-1 py-3 bg-[#00F0FF] hover:bg-cyan-400 active:bg-cyan-500 text-black font-bold text-xs rounded-xl shadow-md transition-colors flex items-center justify-center space-x-1.5">
                    <span>Perbarui Produk</span>
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
