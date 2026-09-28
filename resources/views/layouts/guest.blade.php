<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'StageTrack') }}</title>

        <!-- Fonts & Icons -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            (function() {
                const savedTheme = localStorage.getItem('theme');
                if (savedTheme === 'light') {
                    document.documentElement.classList.remove('dark');
                } else {
                    document.documentElement.classList.add('dark');
                }
            })();

            function toggleTheme() {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
            }
        </script>
    </head>
    <body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 antialiased selection:bg-indigo-500 selection:text-white min-h-screen flex flex-col items-center justify-center p-4 transition-colors duration-300 relative">
        
        <!-- Dark / Light Mode Switcher Floating Button -->
        <div class="absolute top-4 right-4">
            <button onclick="toggleTheme()" type="button" title="Changer le mode sombre/clair" 
                    class="p-2.5 rounded-full text-slate-600 dark:text-slate-300 hover:text-amber-500 dark:hover:text-amber-400 bg-white dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/80 transition-all duration-200 hover:scale-110 shadow-sm flex items-center justify-center">
                <i class="fa-solid fa-sun text-amber-400 text-sm hidden dark:inline"></i>
                <i class="fa-solid fa-moon text-indigo-600 text-sm dark:hidden"></i>
            </button>
        </div>

        <div class="w-full max-w-md space-y-6">
            <div class="text-center space-y-2">
                <a href="/" class="inline-flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl gradient-bg-primary flex items-center justify-center text-white text-xl font-black shadow-lg shadow-indigo-500/30">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <span class="text-2xl font-black gradient-text tracking-tight">StageTrack</span>
                </a>
            </div>

            <div class="glass-panel p-8 rounded-3xl shadow-2xl space-y-6 border border-slate-200 dark:border-slate-700/80 bg-white/90 dark:bg-slate-900/80">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
