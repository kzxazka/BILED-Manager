@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Header & Navigation -->
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('settings') }}" class="text-xs text-[#00F0FF] font-medium flex items-center space-x-1 mb-1 hover:underline">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Pengaturan</span>
            </a>
            <h2 class="text-xl font-bold text-zinc-100">Master Tarif Jasa</h2>
        </div>
        <span class="text-xs bg-zinc-900 border border-zinc-800 text-zinc-400 font-semibold px-2.5 py-1 rounded-full">
            {{ $services->count() }} Total
        </span>
    </div>

    <!-- Create Service Card -->
    @if(!request('edit_id'))
        <div class="bg-zinc-900/90 rounded-2xl p-4 border border-zinc-800 shadow-sm">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-zinc-400 mb-3">Tambah Tarif Jasa Baru</h3>
            <form action="{{ route('services.store') }}" method="POST" class="space-y-3">
                @csrf
                <div class="flex flex-col space-y-3">
                    <div>
                        <input type="text" name="name" placeholder="Nama Jasa (contoh: Bobok Lampu Standard)" required
                               class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-3 py-2.5 text-xs text-zinc-200 placeholder-zinc-700 focus:outline-none focus:border-[#00F0FF]/50 transition-colors">
                    </div>
                    <div class="flex space-x-2">
                        <input type="number" name="base_price" placeholder="Tarif Base (contoh: 250000)" required min="0"
                               class="flex-grow bg-zinc-950 border border-zinc-800 rounded-xl px-3 py-2.5 text-xs text-zinc-200 placeholder-zinc-700 focus:outline-none focus:border-[#00F0FF]/50 transition-colors">
                        <button type="submit" 
                                class="bg-[#00F0FF] hover:bg-cyan-400 active:bg-cyan-500 text-black font-semibold text-xs px-4 rounded-xl shadow-md transition-colors flex items-center justify-center">
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    <!-- Services List -->
    <div class="space-y-3">
        <h3 class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Daftar Tarif Jasa</h3>
        
        @forelse($services as $service)
            <div class="bg-zinc-900/90 rounded-2xl p-4 border border-zinc-800 shadow-sm">
                @if(request('edit_id') == $service->id)
                    <!-- Edit Form Inline -->
                    <form action="{{ route('services.update', $service->id) }}" method="POST" class="space-y-3">
                        @csrf
                        @method('PUT')
                        <div class="space-y-3">
                            <div class="flex flex-col space-y-1">
                                <label class="text-[10px] text-zinc-400 font-semibold uppercase">Nama Jasa</label>
                                <input type="text" name="name" value="{{ old('name', $service->name) }}" required
                                       class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-3 py-2.5 text-xs text-zinc-200 focus:outline-none focus:border-[#00F0FF]/50">
                            </div>
                            <div class="flex flex-col space-y-1">
                                <label class="text-[10px] text-zinc-400 font-semibold uppercase">Tarif Base (Rp)</label>
                                <div class="flex space-x-2">
                                    <input type="number" name="base_price" value="{{ old('base_price', intval($service->base_price)) }}" required min="0"
                                           class="flex-grow bg-zinc-950 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-zinc-200 focus:outline-none focus:border-[#00F0FF]/50">
                                    <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-black font-bold text-xs px-3 rounded-xl transition-colors">
                                        Simpan
                                    </button>
                                    <a href="{{ route('services.index') }}" class="bg-zinc-800 hover:bg-zinc-750 text-zinc-300 text-xs px-3 py-2 rounded-xl flex items-center justify-center transition-colors">
                                        Batal
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                @else
                    <!-- Display Mode -->
                    <div class="flex items-center justify-between">
                        <div class="space-y-1">
                            <h4 class="text-sm font-semibold text-zinc-100">{{ $service->name }}</h4>
                            <p class="text-xs font-semibold text-emerald-400">Rp {{ number_format($service->base_price, 0, ',', '.') }}</p>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <!-- Edit Button -->
                            <a href="{{ route('services.index', ['edit_id' => $service->id]) }}" 
                               class="p-2 bg-zinc-850 hover:bg-zinc-800 border border-zinc-800 rounded-xl text-zinc-400 hover:text-zinc-200 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>
                            
                            <!-- Delete Button -->
                            <form action="{{ route('services.destroy', $service->id) }}" method="POST" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus jasa ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-2 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 rounded-xl text-rose-400 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-zinc-900/50 rounded-2xl p-6 text-center border border-zinc-800">
                <svg class="w-8 h-8 mx-auto text-zinc-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <p class="text-xs text-zinc-500">Tarif jasa belum tersedia.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection
