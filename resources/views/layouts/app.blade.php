<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $title ?? 'BILED Manager' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #121214;
            -webkit-tap-highlight-color: transparent;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #121214;
        }
        ::-webkit-scrollbar-thumb {
            background: #2a2a2e;
            border-radius: 3px;
        }
    </style>
</head>
<body class="text-zinc-200 min-h-screen pb-24">
    
    <!-- Top Header -->
    <header class="sticky top-0 z-30 bg-[#121214]/80 backdrop-blur-md border-b border-zinc-800/80 px-4 py-3 flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-[#00F0FF] to-blue-600 flex items-center justify-center shadow-lg shadow-cyan-500/20">
                <span class="text-black font-bold text-lg">B</span>
            </div>
            <div>
                <h1 class="text-sm font-semibold tracking-wide text-zinc-100">BILED MANAGER</h1>
                <p class="text-[10px] text-zinc-500 uppercase tracking-widest">Workshop ERP</p>
            </div>
        </div>
        
        <!-- Status Indicator -->
        <div class="flex items-center space-x-1.5 bg-zinc-900 border border-zinc-800 rounded-full px-2.5 py-1">
            <span class="w-2 h-2 rounded-full bg-[#00F0FF] animate-pulse"></span>
            <span class="text-[10px] font-medium text-zinc-400">Local Server</span>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="px-4 py-6 max-w-lg mx-auto">
        <!-- Toast Alerts -->
        @if (session('success'))
            <div class="mb-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl p-4 flex items-start space-x-3 shadow-lg shadow-emerald-500/5">
                <svg class="w-5 h-5 mt-0.5 flex-shrink-0 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm font-medium">{{ session('success') }}</div>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-xl p-4 flex items-start space-x-3 shadow-lg shadow-rose-500/5">
                <svg class="w-5 h-5 mt-0.5 flex-shrink-0 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div class="text-sm font-medium">{{ session('error') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-xl p-4 shadow-lg shadow-rose-500/5">
                <div class="flex items-start space-x-3 mb-2">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div class="text-sm font-semibold">Terdapat kesalahan input:</div>
                </div>
                <ul class="list-disc list-inside text-xs text-rose-300/90 pl-2 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Fixed Bottom Navigation Bar -->
    <nav class="fixed bottom-0 left-0 right-0 z-40 bg-[#121214]/90 backdrop-blur-lg border-t border-zinc-800/80 pb-safe">
        <div class="max-w-lg mx-auto flex items-center justify-around h-16 px-2">
            <!-- Dashboard Link -->
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center w-12 h-12 rounded-xl transition-colors {{ request()->routeIs('dashboard') ? 'text-[#00F0FF]' : 'text-zinc-500 hover:text-zinc-300' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="text-[9px] font-medium mt-1">Dashboard</span>
            </a>

            <!-- New Project Link -->
            <a href="{{ route('projects.index') }}" class="flex flex-col items-center justify-center w-12 h-12 rounded-xl transition-colors {{ request()->routeIs('projects.*') ? 'text-[#00F0FF]' : 'text-zinc-500 hover:text-zinc-300' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-[9px] font-medium mt-1">Proyek</span>
            </a>

            <!-- Products Link -->
            <a href="{{ route('products.index') }}" class="flex flex-col items-center justify-center w-12 h-12 rounded-xl transition-colors {{ request()->routeIs('products.*') ? 'text-[#00F0FF]' : 'text-zinc-500 hover:text-zinc-300' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <span class="text-[9px] font-medium mt-1">Stok</span>
            </a>

            <!-- Expenses Link -->
            <a href="{{ route('expenses.index') }}" class="flex flex-col items-center justify-center w-12 h-12 rounded-xl transition-colors {{ request()->routeIs('expenses.*') ? 'text-[#00F0FF]' : 'text-zinc-500 hover:text-zinc-300' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-[9px] font-medium mt-1">Pengeluaran</span>
            </a>

            <!-- Settings / Config Link -->
            <a href="{{ route('settings') }}" class="flex flex-col items-center justify-center w-12 h-12 rounded-xl transition-colors {{ request()->routeIs('settings') || request()->routeIs('categories.*') || request()->routeIs('services.*') ? 'text-[#00F0FF]' : 'text-zinc-500 hover:text-zinc-300' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="text-[9px] font-medium mt-1">Pengaturan</span>
            </a>
        </div>
    </nav>

</body>
</html>
