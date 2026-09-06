<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Suivi Stagiaires') }}</title>

        <!-- Fonts & Icons -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-950 text-slate-100 antialiased selection:bg-indigo-500 selection:text-white min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md space-y-6">
            <div class="text-center space-y-2">
                <a href="/" class="inline-flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl gradient-bg-primary flex items-center justify-center text-white text-xl font-black shadow-lg shadow-indigo-500/30">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <span class="text-2xl font-black gradient-text tracking-tight">Suivi Stagiaires</span>
                </a>
            </div>

            <div class="glass-panel p-8 rounded-3xl shadow-2xl space-y-6 border border-slate-700/80">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
