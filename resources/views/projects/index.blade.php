@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-zinc-100">Daftar Proyek</h2>
            <p class="text-xs text-zinc-400">Kelola antrean dan riwayat pengerjaan</p>
        </div>
        <a href="{{ route('projects.create') }}" 
           class="bg-[#00F0FF] hover:bg-cyan-400 active:bg-cyan-500 text-black font-semibold text-xs px-3.5 py-2.5 rounded-xl shadow-md transition-colors flex items-center space-x-1.5">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Proyek Baru</span>
        </a>
    </div>

    <!-- Status Filter Buttons -->
    <div class="flex space-x-2 overflow-x-auto pb-1 scrollbar-none">
        <a href="{{ route('projects.index') }}" 
           class="px-4 py-2 text-xs font-semibold rounded-full border transition-all flex-shrink-0 {{ !$status ? 'bg-[#00F0FF] text-black border-transparent' : 'bg-zinc-900 border-zinc-800 text-zinc-400 hover:text-zinc-200' }}">
            Semua
        </a>
        <a href="{{ route('projects.index', ['status' => 'completed']) }}" 
           class="px-4 py-2 text-xs font-semibold rounded-full border transition-all flex-shrink-0 {{ $status === 'completed' ? 'bg-emerald-500 text-black border-transparent' : 'bg-zinc-900 border-zinc-800 text-zinc-400 hover:text-zinc-250' }}">
            Selesai
        </a>
        <a href="{{ route('projects.index', ['status' => 'pending']) }}" 
           class="px-4 py-2 text-xs font-semibold rounded-full border transition-all flex-shrink-0 {{ $status === 'pending' ? 'bg-amber-500 text-black border-transparent' : 'bg-zinc-900 border-zinc-800 text-zinc-400 hover:text-zinc-250' }}">
            Proses
        </a>
        <a href="{{ route('projects.index', ['status' => 'cancelled']) }}" 
           class="px-4 py-2 text-xs font-semibold rounded-full border transition-all flex-shrink-0 {{ $status === 'cancelled' ? 'bg-zinc-700 text-zinc-200 border-transparent' : 'bg-zinc-900 border-zinc-800 text-zinc-400 hover:text-zinc-250' }}">
            Batal
        </a>
    </div>

    <!-- Projects List -->
    <div class="space-y-3">
        @forelse($projects as $project)
            <a href="{{ route('projects.show', $project->id) }}" 
               class="block bg-zinc-900/90 hover:bg-zinc-850 rounded-2xl p-4 border border-zinc-800 transition-all shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="space-y-2">
                        <!-- Invoice & Customer -->
                        <div class="space-y-1">
                            <div class="flex items-center space-x-2">
                                <span class="text-[9px] bg-zinc-850 text-zinc-300 font-mono px-2 py-0.5 rounded border border-zinc-750">
                                    {{ $project->invoice_code }}
                                </span>
                                <span class="text-[10px] text-zinc-500">{{ $project->created_at->format('d M Y') }}</span>
                            </div>
                            <h4 class="text-sm font-bold text-zinc-100">{{ $project->customer_name }}</h4>
                        </div>
                        
                        <!-- Vehicle & Revenue -->
                        <div class="flex items-center space-x-3 text-xs">
                            <span class="text-zinc-500">{{ $project->license_plate ?? 'Tanpa Plat' }}</span>
                            <span class="text-zinc-650">•</span>
                            <span class="font-bold text-zinc-300">Rp {{ number_format($project->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Status Indicator -->
                    <div class="flex flex-col items-end space-y-2">
                        @if($project->status === 'completed')
                            <span class="text-[9px] font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2.5 py-1 rounded-full uppercase tracking-wider">
                                Selesai
                            </span>
                        @elseif($project->status === 'pending')
                            <span class="text-[9px] font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20 px-2.5 py-1 rounded-full uppercase tracking-wider">
                                Proses
                            </span>
                        @else
                            <span class="text-[9px] font-semibold bg-zinc-800 text-zinc-400 border border-zinc-750 px-2.5 py-1 rounded-full uppercase tracking-wider">
                                Batal
                            </span>
                        @endif
                        
                        <span class="text-[10px] text-[#00F0FF] flex items-center space-x-0.5 hover:underline">
                            <span>Detail</span>
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    </div>
                </div>
            </a>
        @empty
            <div class="bg-zinc-900/50 rounded-2xl p-8 text-center border border-zinc-800">
                <svg class="w-10 h-10 mx-auto text-zinc-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p class="text-xs text-zinc-500">Belum ada proyek pengerjaan yang tercatat.</p>
                <a href="{{ route('projects.create') }}" class="text-xs text-[#00F0FF] mt-2 inline-block font-semibold hover:underline">Buat Proyek Pertama</a>
            </div>
        @endforelse
    </div>

</div>
@endsection
