<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Suivi Stagiaires')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans antialiased">

    <nav class="bg-purple-900 text-white px-6 py-3 flex justify-between items-center shadow">
        <span class="font-bold text-lg">🎓 Suivi Stagiaires</span>
        <div class="flex items-center gap-4">
            <span class="text-sm">{{ auth()->user()->nom ?? '' }}</span>
            <span class="text-xs bg-purple-700 px-2 py-1 rounded uppercase">{{ auth()->user()->role ?? '' }}</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-sm underline hover:text-purple-200">Déconnexion</button>
            </form>
        </div>
    </nav>

    <div class="flex min-h-screen">
        <aside class="w-56 bg-purple-800 text-white flex-shrink-0 py-6 px-3 space-y-1 shadow-lg">
            @yield('sidebar')
        </aside>

        <main class="flex-1 p-6">
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 border border-green-300 rounded flex items-center gap-3">
                    <span>{{ session('success') }}</span>
                    @if(session('whatsapp_link'))
                        <a href="{{ session('whatsapp_link') }}" target="_blank"
                           class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                            📱 Envoyer via WhatsApp
                        </a>
                    @endif
                </div>
            @endif
            @if($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-800 border border-red-300 rounded text-sm">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
