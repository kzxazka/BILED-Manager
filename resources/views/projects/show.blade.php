@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Header & Back Navigation -->
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('projects.index') }}" class="text-xs text-[#00F0FF] font-medium flex items-center space-x-1 mb-1 hover:underline">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Daftar Proyek</span>
            </a>
            <h2 class="text-xl font-bold text-zinc-100">Detail Proyek</h2>
        </div>
        
        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" 
              onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini? Penghapusan akan mengembalikan stok jika status sudah Selesai.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-xs bg-rose-500/10 hover:bg-rose-500/20 text-rose-455 border border-rose-500/20 px-3 py-2 rounded-xl transition-colors">
                Hapus Proyek
            </button>
        </form>
    </div>

    <!-- Main Receipt Card -->
    <div class="bg-zinc-900/90 rounded-2xl p-5 border border-zinc-800 shadow-sm space-y-5">
        <!-- Receipt Top Header -->
        <div class="flex justify-between items-start border-b border-zinc-800 pb-4">
            <div class="space-y-1">
                <span class="text-[10px] bg-zinc-850 text-zinc-300 font-mono px-2 py-0.5 rounded border border-zinc-750">
                    {{ $project->invoice_code }}
                </span>
                <h3 class="text-sm font-bold text-zinc-100 mt-1">{{ $project->customer_name }}</h3>
                <p class="text-[10px] text-zinc-500 font-mono">{{ $project->license_plate ?? 'Tanpa Plat Nomor' }}</p>
            </div>
            
            <div class="text-right space-y-1">
                <div class="text-[10px] text-zinc-500">{{ $project->created_at->format('d M Y H:i') }}</div>
                <div>
                    @if($project->status === 'completed')
                        <span class="text-[9px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                            Selesai
                        </span>
                    @elseif($project->status === 'pending')
                        <span class="text-[9px] font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20 px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                            Proses
                        </span>
                    @else
                        <span class="text-[9px] font-bold bg-zinc-800 text-zinc-400 border border-zinc-750 px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                            Batal
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Materials & Services Breakdown -->
        <div class="space-y-3">
            <h4 class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Rincian Transaksi</h4>

            <div class="space-y-2">
                <!-- Project Items -->
                @foreach($project->projectItems as $item)
                    <div class="flex justify-between items-center text-xs py-1 border-b border-zinc-800/40">
                        <div class="space-y-0.5 pr-4">
                            <div class="font-medium text-zinc-300">{{ $item->product->name }}</div>
                            <div class="text-[10px] text-zinc-500">
                                {{ $item->quantity }} x Rp {{ number_format($item->sell_price_at_sale, 0, ',', '.') }}
                                <span class="text-zinc-650 ml-1">(HPP: Rp {{ number_format($item->hpp_at_sale, 0, ',', '.') }})</span>
                            </div>
                        </div>
                        <div class="font-semibold text-zinc-200">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </div>
                    </div>
                @endforeach

                <!-- Labor Fee -->
                <div class="flex justify-between items-center text-xs py-1 border-b border-zinc-850">
                    <div class="space-y-0.5">
                        <div class="font-medium text-zinc-300">Biaya Jasa Pengerjaan / Labor</div>
                        <div class="text-[10px] text-zinc-500">Instalasi & retrofit custom</div>
                    </div>
                    <div class="font-semibold text-zinc-200">
                        Rp {{ number_format($project->labor_fee, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Totals & Profit Breakdown -->
        <div class="space-y-2.5 bg-zinc-950/60 border border-zinc-900 rounded-xl p-3.5">
            <!-- Total Materials Sell -->
            <div class="flex justify-between items-center text-xs">
                <span class="text-zinc-400">Total Bahan</span>
                <span class="font-medium text-zinc-300">Rp {{ number_format($project->total_amount - $project->labor_fee, 0, ',', '.') }}</span>
            </div>

            <!-- Labor Fee -->
            <div class="flex justify-between items-center text-xs">
                <span class="text-zinc-400">Total Biaya Jasa</span>
                <span class="font-medium text-zinc-300">Rp {{ number_format($project->labor_fee, 0, ',', '.') }}</span>
            </div>

            <!-- Grand Total -->
            <div class="flex justify-between items-center text-sm pt-2 border-t border-zinc-900 font-bold">
                <span class="text-zinc-300">Total Tagihan</span>
                <span class="text-[#00F0FF]">Rp {{ number_format($project->total_amount, 0, ',', '.') }}</span>
            </div>

            <!-- Profit Summary Card -->
            <div class="pt-3.5 border-t border-zinc-900 grid grid-cols-2 gap-4">
                <div>
                    <span class="text-[8px] text-zinc-500 uppercase font-bold tracking-wider">Total HPP Bahan</span>
                    <div class="text-xs font-semibold text-zinc-400">Rp {{ number_format($project->total_hpp, 0, ',', '.') }}</div>
                </div>
                <div>
                    <span class="text-[8px] text-zinc-500 uppercase font-bold tracking-wider">Laba Bersih Proyek</span>
                    <div class="text-xs font-semibold text-emerald-400">Rp {{ number_format($project->net_profit, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Status Update Card -->
    <div class="bg-zinc-900/90 rounded-2xl p-5 border border-zinc-800 shadow-sm space-y-4">
        <h3 class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Perbarui Status Proyek</h3>
        
        <form action="{{ route('projects.update', $project->id) }}" method="POST" class="flex space-x-2">
            @csrf
            @method('PUT')
            <div class="flex-grow">
                <select name="status" required
                        class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-3 py-2.5 text-xs text-zinc-200 focus:outline-none focus:border-[#00F0FF]/50 transition-colors">
                    <option value="pending" {{ $project->status === 'pending' ? 'selected' : '' }}>Proses (Pending)</option>
                    <option value="completed" {{ $project->status === 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
                    <option value="cancelled" {{ $project->status === 'cancelled' ? 'selected' : '' }}>Batal (Cancelled)</option>
                </select>
            </div>
            <button type="submit" 
                    class="bg-[#00F0FF] hover:bg-cyan-400 active:bg-cyan-500 text-black font-semibold text-xs px-4 rounded-xl shadow-md transition-colors">
                Perbarui
            </button>
        </form>
    </div>

</div>
@endsection
