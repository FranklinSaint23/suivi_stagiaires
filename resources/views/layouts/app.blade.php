<!DOCTYPE html>
<html lang="fr" class="dark h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Suivi Stagiaires')</title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full bg-slate-950 text-slate-100 font-sans antialiased selection:bg-indigo-500 selection:text-white" x-data="{ sidebarOpen: false }">

    <!-- Top Navigation Bar -->
    <header class="sticky top-0 z-30 bg-slate-900/80 backdrop-blur-md border-b border-slate-800/80 px-4 sm:px-6 py-3">
        <div class="flex items-center justify-between">
            <!-- Left: Brand & Mobile Toggle -->
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = !sidebarOpen" 
                        type="button" 
                        class="md:hidden text-slate-400 hover:text-white p-2 rounded-lg hover:bg-slate-800/80 transition"
                        aria-label="Toggle navigation menu">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>

                <a href="/" class="flex items-center gap-2.5 group">
                    <div class="w-10 h-10 rounded-xl gradient-bg-primary flex items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:scale-105 transition-transform duration-200">
                        <i class="fa-solid fa-graduation-cap text-white text-lg"></i>
                    </div>
                    <span class="font-extrabold text-lg sm:text-xl tracking-tight text-white group-hover:text-indigo-300 transition">
                        Suivi<span class="gradient-text">Stagiaires</span>
                    </span>
                </a>
            </div>

            <!-- Right: User Profile & Actions -->
            <div class="flex items-center gap-3 sm:gap-4">
                @auth
                    <div class="hidden sm:flex flex-col items-end text-right">
                        <span class="text-sm font-semibold text-slate-200">{{ auth()->user()->nom ?? '' }}</span>
                        <span class="text-[10px] font-bold tracking-wider uppercase bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 px-2 py-0.5 rounded-full">
                            {{ auth()->user()->role ?? '' }}
                        </span>
                    </div>

                    <div class="w-9 h-9 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-indigo-400 font-semibold text-sm">
                        <i class="fa-solid fa-user-gear"></i>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                title="Se déconnecter"
                                class="inline-flex items-center justify-center p-2 sm:px-3 sm:py-1.5 text-xs sm:text-sm font-medium text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 border border-transparent hover:border-rose-500/20 rounded-lg transition duration-200">
                            <i class="fa-solid fa-right-from-bracket sm:mr-1.5"></i>
                            <span class="hidden sm:inline">Déconnexion</span>
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </header>

    <div class="flex min-h-[calc(100vh-61px)]">
        <!-- Mobile Sidebar Drawer Overlay -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 z-40 bg-slate-950/80 backdrop-blur-sm md:hidden"
             style="display: none;"></div>

        <!-- Mobile Off-Canvas Sidebar -->
        <aside x-show="sidebarOpen" 
               x-transition:enter="transition ease-in-out duration-300 transform"
               x-transition:enter-start="-translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transition ease-in-out duration-300 transform"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="-translate-x-full"
               class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900/95 backdrop-blur-xl border-r border-slate-800 p-4 shadow-2xl flex flex-col justify-between md:hidden"
               style="display: none;">
            <div>
                <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-800">
                    <span class="font-bold text-slate-300 text-sm tracking-wider uppercase flex items-center gap-2">
                        <i class="fa-solid fa-compass text-indigo-400"></i> Navigation
                    </span>
                    <button @click="sidebarOpen = false" class="text-slate-400 hover:text-white p-1 rounded-lg">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>
                <div class="space-y-1">
                    @yield('sidebar')
                </div>
            </div>
        </aside>

        <!-- Desktop Permanent Sidebar -->
        <aside class="hidden md:block w-64 bg-slate-900/60 border-r border-slate-800/80 p-4 flex-shrink-0 min-h-full">
            <div class="sticky top-20 space-y-1">
                @yield('sidebar')
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 min-w-0 p-4 sm:p-6 lg:p-8 bg-slate-950 text-slate-100 overflow-x-hidden">
            <div class="max-w-7xl mx-auto space-y-6">
                <!-- Notifications / Flash Alerts -->
                @if(session('success'))
                    <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl flex flex-wrap items-center justify-between gap-3 shadow-lg shadow-emerald-500/5">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-check text-emerald-400 text-lg"></i>
                            <span class="text-sm font-medium">{{ session('success') }}</span>
                        </div>
                        @if(session('whatsapp_link'))
                            <a href="{{ session('whatsapp_link') }}" target="_blank"
                               class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold px-3 py-1.5 rounded-lg shadow-md transition">
                                <i class="fa-brands fa-whatsapp text-sm"></i> Envoyer via WhatsApp
                            </a>
                        @endif
                    </div>
                @endif

                @if($errors->any())
                    <div class="p-4 bg-rose-500/10 border border-rose-500/20 text-rose-300 rounded-xl shadow-lg shadow-rose-500/5">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fa-solid fa-triangle-exclamation text-rose-400 text-lg"></i>
                            <span class="text-sm font-semibold text-rose-200">Veuillez corriger les erreurs suivantes :</span>
                        </div>
                        <ul class="list-disc pl-9 text-xs sm:text-sm space-y-1 text-rose-300/90">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>

