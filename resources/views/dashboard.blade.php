@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Top Headline -->
    <div>
        <h2 class="text-xl font-bold text-zinc-100">Ringkasan Keuangan</h2>
        <p class="text-xs text-zinc-400">Status keuangan bengkel realtime</p>
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-2 gap-4">
        <!-- Net Profit Card (Full Width Span) -->
        <div class="col-span-2 bg-gradient-to-br from-emerald-600 to-teal-800 rounded-2xl p-4 shadow-lg shadow-emerald-950/20 border border-emerald-500/20">
            <span class="text-[10px] font-semibold uppercase tracking-widest text-emerald-200/80">Net Profit</span>
            <div class="text-2xl font-bold text-white mt-1">
                Rp {{ number_format($netProfit, 0, ',', '.') }}
            </div>
            <p class="text-[10px] text-emerald-100/70 mt-1">Total Pendapatan Bersih</p>
        </div>

        <!-- Revenue Card -->
        <div class="bg-zinc-900/90 rounded-2xl p-4 border border-zinc-800 shadow-md">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] font-semibold uppercase tracking-widest text-zinc-400">Total Omset</span>
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            </div>
            <div class="text-base font-bold text-zinc-100">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </div>
        </div>

        <!-- Cost of Goods Card (HPP) -->
        <div class="bg-zinc-900/90 rounded-2xl p-4 border border-zinc-800 shadow-md">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] font-semibold uppercase tracking-widest text-zinc-400">Total HPP</span>
                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
            </div>
            <div class="text-base font-bold text-zinc-100">
                Rp {{ number_format($totalHpp, 0, ',', '.') }}
            </div>
        </div>

        <!-- Expenses Card -->
        <div class="bg-zinc-900/90 rounded-2xl p-4 border border-zinc-800 shadow-md">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] font-semibold uppercase tracking-widest text-zinc-400">Pengeluaran</span>
                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
            </div>
            <div class="text-base font-bold text-zinc-100">
                Rp {{ number_format($totalExpenses, 0, ',', '.') }}
            </div>
        </div>

        <!-- Labor Fees Card (Calculated as Gross - HPP) -->
        <div class="bg-zinc-900/90 rounded-2xl p-4 border border-zinc-800 shadow-md">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] font-semibold uppercase tracking-widest text-zinc-400">Laba Transaksi</span>
                <span class="w-2 h-2 rounded-full bg-cyan-400"></span>
            </div>
            <div class="text-base font-bold text-zinc-100">
                Rp {{ number_format($totalRevenue - $totalHpp, 0, ',', '.') }}
            </div>
        </div>
    </div>

    <!-- Low Stock Banner Alert -->
    @if($lowStockProducts->count() > 0)
        <div class="bg-amber-500/10 border border-amber-500/20 rounded-2xl p-4 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center space-x-2 text-amber-400">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span class="text-sm font-semibold">Peringatan Stok Rendah</span>
                </div>
                <span class="text-[10px] bg-amber-500/20 text-amber-300 font-medium px-2 py-0.5 rounded-full">
                    {{ $lowStockProducts->count() }} Item
                </span>
            </div>
            <div class="text-xs text-zinc-400 space-y-2 mt-3">
                @foreach($lowStockProducts as $product)
                    <div class="flex justify-between items-center bg-zinc-950/40 p-2 rounded-lg border border-zinc-900">
                        <span class="font-medium text-zinc-300">{{ $product->name }}</span>
                        <span class="text-rose-400 font-semibold">{{ $product->stock }} / {{ $product->min_stock }} sisa</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Recent Projects Section -->
    <div class="space-y-3">
        <div class="flex justify-between items-center">
            <h3 class="text-base font-bold text-zinc-100">Proyek Terbaru</h3>
            <a href="#" class="text-xs text-[#00F0FF] font-medium hover:underline">Lihat Semua</a>
        </div>

        <div class="space-y-3">
            @forelse($recentProjects as $project)
                <div class="bg-zinc-900/90 rounded-2xl p-4 border border-zinc-800 shadow-sm flex items-center justify-between">
                    <div class="space-y-1.5">
                        <div class="flex items-center space-x-2">
                            <span class="text-[10px] bg-zinc-800 text-zinc-300 font-mono px-2 py-0.5 rounded border border-zinc-700">
                                {{ $project->invoice_code }}
                            </span>
                            <span class="text-xs font-semibold text-zinc-100">{{ $project->customer_name }}</span>
                        </div>
                        <div class="text-[10px] text-zinc-400 flex items-center space-x-2">
                            <span class="text-zinc-500">{{ $project->license_plate ?? 'Tanpa Plat' }}</span>
                            <span>•</span>
                            <span class="font-medium text-zinc-300">Rp {{ number_format($project->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <!-- Status Badge -->
                    <div>
                        @if($project->status === 'completed')
                            <span class="text-[9px] font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2.5 py-1 rounded-full uppercase tracking-wider">
                                Selesai
                            </span>
                        @elseif($project->status === 'pending')
                            <span class="text-[9px] font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20 px-2.5 py-1 rounded-full uppercase tracking-wider">
                                Proses
                            </span>
                        @else
                            <span class="text-[9px] font-semibold bg-zinc-800 text-zinc-400 border border-zinc-700 px-2.5 py-1 rounded-full uppercase tracking-wider">
                                Batal
                            </span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-zinc-900/50 rounded-2xl p-6 text-center border border-zinc-800">
                    <svg class="w-8 h-8 mx-auto text-zinc-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="text-xs text-zinc-500">Belum ada transaksi terekam.</p>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
