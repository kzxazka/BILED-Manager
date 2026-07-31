@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div>
        <h2 class="text-xl font-bold text-zinc-100">Pengaturan</h2>
        <p class="text-xs text-zinc-400">Kelola master data dan konfigurasi sistem</p>
    </div>

    <!-- Navigation Menu Cards -->
    <div class="space-y-3">
        <!-- Categories CRUD Link -->
        <a href="{{ route('categories.index') }}" class="flex items-center justify-between p-4 bg-zinc-900/90 hover:bg-zinc-850 rounded-2xl border border-zinc-800 transition-all shadow-sm">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-cyan-500/10 flex items-center justify-center text-[#00F0FF]">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-zinc-100">Master Kategori</h3>
                    <p class="text-[10px] text-zinc-400">Atur kategori stok produk / bahan</p>
                </div>
            </div>
            <svg class="w-5 h-5 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>

        <!-- Services CRUD Link -->
        <a href="{{ route('services.index') }}" class="flex items-center justify-between p-4 bg-zinc-900/90 hover:bg-zinc-850 rounded-2xl border border-zinc-800 transition-all shadow-sm">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-400">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-zinc-100">Master Tarif Jasa</h3>
                    <p class="text-[10px] text-zinc-400">Atur tarif jasa instalasi & pengerjaan</p>
                </div>
            </div>
            <svg class="w-5 h-5 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>

    <!-- Danger Zone Card -->
    <div class="bg-rose-500/5 rounded-2xl p-4 border border-rose-500/15 shadow-sm space-y-4">
        <div>
            <h3 class="text-sm font-bold text-rose-400 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>Zona Bahaya</span>
            </h3>
            <p class="text-[10px] text-zinc-400 mt-1">Mengosongkan sistem akan menghapus seluruh data Kategori, Produk, Jasa, Transaksi/Proyek, dan Catatan Pengeluaran secara permanen.</p>
        </div>

        <form action="{{ route('settings.purge') }}" method="POST" class="space-y-3">
            @csrf
            <div class="space-y-1">
                <label for="confirm_purge" class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wide">Konfirmasi Penghapusan</label>
                <input type="text" id="confirm_purge" name="confirm_purge" placeholder="Ketik 'HAPUS' untuk konfirmasi" required
                       class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-rose-400 placeholder-zinc-700 focus:outline-none focus:border-rose-500/50 transition-colors">
            </div>
            
            <button type="submit" 
                    class="w-full py-2.5 bg-rose-600 hover:bg-rose-700 active:bg-rose-800 text-white font-semibold text-xs rounded-xl shadow-md transition-colors flex items-center justify-center space-x-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                <span>Kosongkan Seluruh Data</span>
            </button>
        </form>
    </div>

</div>
@endsection
