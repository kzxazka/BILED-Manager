@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div>
        <a href="{{ route('projects.index') }}" class="text-xs text-[#00F0FF] font-medium flex items-center space-x-1 mb-1 hover:underline">
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span>Daftar Proyek</span>
        </a>
        <h2 class="text-xl font-bold text-zinc-100">Buat Proyek Baru</h2>
        <p class="text-xs text-zinc-400">Buat intake order pengerjaan retrofit baru</p>
    </div>

    <!-- Form -->
    <form action="{{ route('projects.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Customer Card -->
        <div class="bg-zinc-900/90 rounded-2xl p-5 border border-zinc-800 shadow-sm space-y-4">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Data Pelanggan</h3>
            
            <div class="space-y-1">
                <label for="customer_name" class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wide">Nama Pelanggan</label>
                <input type="text" name="customer_name" id="customer_name" placeholder="contoh: Ahmad Faisal" value="{{ old('customer_name') }}" required
                       class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-3 py-3 text-xs text-zinc-200 placeholder-zinc-700 focus:outline-none focus:border-[#00F0FF]/50 transition-colors">
            </div>

            <div class="space-y-1">
                <label for="license_plate" class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wide">Plat Nomor (Opsional)</label>
                <input type="text" name="license_plate" id="license_plate" placeholder="contoh: B 1234 CDG" value="{{ old('license_plate') }}"
                       class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-3 py-3 text-xs text-zinc-200 placeholder-zinc-700 focus:outline-none focus:border-[#00F0FF]/50 transition-colors">
            </div>
        </div>

        <!-- Labor & Services Card -->
        <div class="bg-zinc-900/90 rounded-2xl p-5 border border-zinc-800 shadow-sm space-y-4">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Jasa & Biaya Pengerjaan</h3>

            <div class="space-y-1">
                <label for="service_selector" class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wide">Preset Jasa (Pilih untuk Autocomplete)</label>
                <select id="service_selector"
                        class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-3 py-3 text-xs text-zinc-200 focus:outline-none focus:border-[#00F0FF]/50 transition-colors">
                    <option value="" disabled selected>-- Pilih Preset Jasa --</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" data-price="{{ $service->base_price }}">
                            {{ $service->name }} (Rp {{ number_format($service->base_price, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1">
                <label for="labor_fee" class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wide">Biaya Jasa (Custom / Final)</label>
                <input type="number" name="labor_fee" id="labor_fee" placeholder="contoh: 750000" value="{{ old('labor_fee', 0) }}" required min="0"
                       class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-3 py-3 text-xs text-zinc-200 placeholder-zinc-700 focus:outline-none focus:border-[#00F0FF]/50 transition-colors">
            </div>
        </div>

        <!-- Materials Picker Card -->
        <div class="bg-zinc-900/90 rounded-2xl p-5 border border-zinc-800 shadow-sm space-y-4">
            <div class="flex justify-between items-center">
                <h3 class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Bahan & Produk Terpakai</h3>
                <button type="button" id="add-product-btn" 
                        class="px-3 py-1.5 bg-zinc-800 hover:bg-zinc-750 text-xs font-semibold text-[#00F0FF] rounded-xl border border-zinc-700 flex items-center space-x-1.5 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Produk</span>
                </button>
            </div>

            <!-- Products List Dynamic Container -->
            <div id="products-container" class="space-y-3">
                <!-- Javascript will append rows here -->
            </div>

            <div id="empty-products-msg" class="text-center py-4 bg-zinc-950/40 border border-dashed border-zinc-800 rounded-xl">
                <p class="text-[11px] text-zinc-500">Belum ada bahan ditambahkan. Klik "Tambah Produk" di atas.</p>
            </div>
        </div>

        <!-- Project Status Card -->
        <div class="bg-zinc-900/90 rounded-2xl p-5 border border-zinc-800 shadow-sm space-y-4">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Status Pengerjaan</h3>

            <div class="space-y-1">
                <label for="status" class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wide">Status Proyek</label>
                <select name="status" id="status" required
                        class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-3 py-3 text-xs text-zinc-200 focus:outline-none focus:border-[#00F0FF]/50 transition-colors">
                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Proses (Pending - Stok Belum Terpotong)</option>
                    <option value="completed" {{ old('status', 'completed') == 'completed' ? 'selected' : '' }}>Selesai (Completed - Stok Langsung Terpotong)</option>
                </select>
                <p class="text-[10px] text-zinc-500 mt-1">Stok produk hanya akan dipotong jika status diset ke 'Selesai'.</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex space-x-3">
            <a href="{{ route('projects.index') }}" 
               class="flex-1 py-3.5 bg-zinc-800 hover:bg-zinc-750 active:bg-zinc-700 text-zinc-300 font-semibold text-xs rounded-xl text-center shadow-sm transition-colors">
                Batal
            </a>
            <button type="submit" 
                    class="flex-1 py-3.5 bg-[#00F0FF] hover:bg-cyan-400 active:bg-cyan-500 text-black font-bold text-xs rounded-xl shadow-md transition-colors flex items-center justify-center space-x-1.5">
                <span>Simpan Proyek</span>
            </button>
        </div>
    </form>

</div>

<!-- Row Template (Hidden) -->
<div id="row-template" class="hidden">
    <div class="product-row flex items-start space-x-2 bg-zinc-950 p-3 rounded-xl border border-zinc-900/80">
        <!-- Product Dropdown -->
        <div class="flex-grow min-w-0">
            <select name="items[INDEX][product_id]" required
                    class="w-full bg-zinc-900 border border-zinc-800 rounded-lg px-2.5 py-2 text-xs text-zinc-200 focus:outline-none focus:border-[#00F0FF]/50">
                <option value="" disabled selected>-- Pilih Produk --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->name }} (Sisa: {{ $product->stock }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Quantity input -->
        <div class="w-16">
            <input type="number" name="items[INDEX][quantity]" value="1" min="1" required
                   class="w-full bg-zinc-900 border border-zinc-800 rounded-lg px-2 py-2 text-xs text-center text-zinc-200 focus:outline-none focus:border-[#00F0FF]/50">
        </div>

        <!-- Delete button -->
        <button type="button" class="remove-row-btn p-2 bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 rounded-lg border border-rose-500/20 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('products-container');
        const addBtn = document.getElementById('add-product-btn');
        const emptyMsg = document.getElementById('empty-products-msg');
        const template = document.getElementById('row-template').firstElementChild;
        let rowIndex = 0;

        function updateEmptyState() {
            if (container.children.length === 0) {
                emptyMsg.classList.remove('hidden');
            } else {
                emptyMsg.classList.add('hidden');
            }
        }

        // Add Product Row
        addBtn.addEventListener('click', function() {
            const clone = template.cloneNode(true);
            
            // Replace INDEX placeholder with current rowIndex
            clone.querySelectorAll('[name]').forEach(input => {
                input.name = input.name.replace('INDEX', rowIndex);
            });

            // Set up delete listener
            clone.querySelector('.remove-row-btn').addEventListener('click', function() {
                clone.remove();
                updateEmptyState();
            });

            container.appendChild(clone);
            rowIndex++;
            updateEmptyState();
        });

        // Setup Autocomplete Labor Fee
        const serviceSelector = document.getElementById('service_selector');
        const laborFeeInput = document.getElementById('labor_fee');

        serviceSelector.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            if (price) {
                laborFeeInput.value = Math.round(price);
            }
        });

        // Add first row automatically
        addBtn.click();
    });
</script>
@endsection
