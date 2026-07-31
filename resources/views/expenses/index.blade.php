@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-zinc-100">Catatan Pengeluaran</h2>
            <p class="text-xs text-zinc-400">Kelola pengeluaran operasional non-inventory</p>
        </div>
        <span class="text-xs bg-zinc-900 border border-zinc-800 text-zinc-400 font-semibold px-2.5 py-1 rounded-full">
            Rp {{ number_format($expenses->sum('amount'), 0, ',', '.') }} Total
        </span>
    </div>

    <!-- Create Expense Card -->
    <div class="bg-zinc-900/90 rounded-2xl p-5 border border-zinc-800 shadow-sm space-y-4">
        <h3 class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Catat Pengeluaran Baru</h3>
        <form action="{{ route('expenses.store') }}" method="POST" class="space-y-3">
            @csrf
            
            <div class="space-y-1">
                <label for="description" class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wide">Deskripsi Pengeluaran</label>
                <input type="text" name="description" id="description" placeholder="contoh: Token Listrik Bengkel" value="{{ old('description') }}" required
                       class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-3 py-2.5 text-xs text-zinc-200 placeholder-zinc-700 focus:outline-none focus:border-rose-500/50 transition-colors">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label for="amount" class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wide">Nominal (Rp)</label>
                    <input type="number" name="amount" id="amount" placeholder="contoh: 150000" value="{{ old('amount') }}" required min="0"
                           class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-3 py-2.5 text-xs text-zinc-200 placeholder-zinc-700 focus:outline-none focus:border-rose-500/50 transition-colors">
                </div>

                <div class="space-y-1">
                    <label for="expense_date" class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wide">Tanggal</label>
                    <input type="date" name="expense_date" id="expense_date" value="{{ old('expense_date', date('Y-m-d')) }}" required
                           class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-3 py-2.5 text-xs text-zinc-200 focus:outline-none focus:border-rose-500/50 transition-colors">
                </div>
            </div>

            <button type="submit" 
                    class="w-full py-2.5 bg-rose-600 hover:bg-rose-700 active:bg-rose-800 text-white font-bold text-xs rounded-xl shadow-md transition-colors flex items-center justify-center space-x-1.5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Simpan Pengeluaran</span>
            </button>
        </form>
    </div>

    <!-- Expenses List -->
    <div class="space-y-3">
        <h3 class="text-xs font-semibold uppercase tracking-wider text-zinc-400 font-bold">Riwayat Pengeluaran</h3>
        
        @forelse($expenses as $expense)
            <div class="bg-zinc-900/90 rounded-2xl p-4 border border-zinc-800 shadow-sm flex items-center justify-between">
                <div class="space-y-1.5">
                    <div class="space-y-0.5">
                        <span class="text-[10px] text-zinc-500 font-medium">{{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}</span>
                        <h4 class="text-sm font-semibold text-zinc-150">{{ $expense->description }}</h4>
                    </div>
                    <div class="text-xs font-bold text-rose-400">
                        Rp {{ number_format($expense->amount, 0, ',', '.') }}
                    </div>
                </div>

                <!-- Delete Button -->
                <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" 
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan pengeluaran ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="p-2 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 rounded-xl text-rose-400 transition-colors flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </form>
            </div>
        @empty
            <div class="bg-zinc-900/50 rounded-2xl p-6 text-center border border-zinc-800">
                <svg class="w-8 h-8 mx-auto text-zinc-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-xs text-zinc-500">Belum ada pengeluaran operasional tercatat.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection
