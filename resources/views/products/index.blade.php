@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-zinc-100">Stok & Bahan</h2>
            <p class="text-xs text-zinc-400">Kelola persediaan barang workshop</p>
        </div>
        <a href="{{ route('products.create') }}" 
           class="bg-[#00F0FF] hover:bg-cyan-400 active:bg-cyan-500 text-black font-semibold text-xs px-3.5 py-2.5 rounded-xl shadow-md transition-colors flex items-center space-x-1.5">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah</span>
        </a>
    </div>

    <!-- Product Grid/List -->
    <div class="space-y-3">
        @forelse($products as $product)
            @php
                $isLowStock = $product->stock <= $product->min_stock;
            @endphp
            <div class="bg-zinc-900/90 rounded-2xl p-4 border transition-all {{ $isLowStock ? 'border-amber-500/30 bg-amber-500/[0.02]' : 'border-zinc-800' }} shadow-sm">
                <div class="flex items-start justify-between">
                    <div class="space-y-2">
                        <!-- Category Badge & Product Name -->
                        <div class="space-y-1">
                            <div class="flex items-center space-x-2">
                                <span class="text-[9px] font-bold bg-zinc-850 border border-zinc-800 text-zinc-400 px-2 py-0.5 rounded-md uppercase tracking-wider">
                                    {{ $product->category->name }}
                                </span>
                                @if($isLowStock)
                                    <span class="text-[9px] font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20 px-2 py-0.5 rounded-md uppercase tracking-wider">
                                        Stok Rendah
                                    </span>
                                @endif
                            </div>
                            <h4 class="text-sm font-semibold text-zinc-100">{{ $product->name }}</h4>
                        </div>
                        
                        <!-- Stock Levels -->
                        <div class="flex items-center space-x-4 text-xs">
                            <div>
                                <span class="text-zinc-500">Stok: </span>
                                <span class="font-bold {{ $isLowStock ? 'text-rose-400' : 'text-zinc-300' }}">{{ $product->stock }}</span>
                            </div>
                            <div class="text-zinc-500">•</div>
                            <div>
                                <span class="text-zinc-500">Min: </span>
                                <span class="font-medium text-zinc-400">{{ $product->min_stock }}</span>
                            </div>
                        </div>

                        <!-- Price Info (HPP & Retail) -->
                        <div class="grid grid-cols-2 gap-x-4 bg-zinc-950/50 rounded-xl p-2.5 border border-zinc-900/80">
                            <div>
                                <span class="text-[9px] text-zinc-500 uppercase tracking-wider font-semibold">Harga HPP (Modal)</span>
                                <div class="text-xs font-semibold text-zinc-300">Rp {{ number_format($product->hpp_price, 0, ',', '.') }}</div>
                            </div>
                            <div>
                                <span class="text-[9px] text-zinc-500 uppercase tracking-wider font-semibold">Harga Jual (Retail)</span>
                                <div class="text-xs font-semibold text-emerald-400">Rp {{ number_format($product->sell_price, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col space-y-2">
                        <!-- Edit Button -->
                        <a href="{{ route('products.edit', $product->id) }}" 
                           class="p-2 bg-zinc-850 hover:bg-zinc-800 border border-zinc-800 rounded-xl text-zinc-400 hover:text-zinc-200 transition-colors flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </a>
                        
                        <!-- Delete Button -->
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini dari stok?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="p-2 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 rounded-xl text-rose-400 transition-colors flex items-center justify-center w-full">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-zinc-900/50 rounded-2xl p-6 text-center border border-zinc-800">
                <svg class="w-8 h-8 mx-auto text-zinc-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <p class="text-xs text-zinc-500">Stok barang belum tersedia.</p>
                <a href="{{ route('products.create') }}" class="text-xs text-[#00F0FF] mt-2 inline-block font-semibold hover:underline">Tambah Produk Pertama</a>
            </div>
        @endforelse
    </div>

</div>
@endsection
