<!DOCTYPE html>
<html lang="fr" class="dark h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuiviStagiaires — Suivi des Stagiaires Assisté par l'IA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 font-sans antialiased selection:bg-indigo-500 selection:text-white overflow-x-hidden">

    <!-- Ambient Glowing Orbs -->
    <div class="fixed -top-20 -left-20 w-[500px] h-[500px] bg-indigo-600/15 rounded-full blur-[140px] pointer-events-none z-0"></div>
    <div class="fixed top-1/3 -right-20 w-[450px] h-[450px] bg-purple-600/15 rounded-full blur-[140px] pointer-events-none z-0"></div>

    <!-- Navigation Header -->
    <header class="sticky top-0 z-50 bg-slate-950/85 backdrop-blur-xl border-b border-slate-800/80 transition duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
            
            <!-- Logo (Sans le badge IA à côté) -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 shrink-0 group">
                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl gradient-bg-primary flex items-center justify-center shadow-lg shadow-indigo-500/25 group-hover:scale-105 transition duration-300">
                    <i class="fa-solid fa-graduation-cap text-xl sm:text-2xl text-white"></i>
                </div>
                <span class="font-extrabold text-xl sm:text-2xl tracking-tight text-white">
                    Suivi<span class="gradient-text">Stagiaires</span>
                </span>
            </a>

            <!-- Navigation Links (Center) -->
            <nav class="hidden lg:flex items-center gap-8 text-sm font-semibold text-slate-300">
                <a href="{{ url('/') }}" class="text-white border-b-2 border-indigo-500 pb-1 font-bold">Accueil</a>
                <a href="#atouts" class="hover:text-indigo-400 transition">Fonctionnalités</a>
                <a href="#presentation" class="hover:text-indigo-400 transition">À propos</a>
                <a href="#contact" class="hover:text-indigo-400 transition">Contact</a>
            </nav>

            <!-- Actions (Right) -->
            <div class="flex items-center gap-3 shrink-0">
                @auth
                    @php
                        $targetRoute = match(auth()->user()->role) {
                            'admin' => route('admin.dashboard'),
                            'encadrant' => route('encadrant.dashboard'),
                            'stagiaire' => route('stagiaire.dashboard'),
                            default => route('login'),
                        };
                    @endphp
                    <a href="{{ $targetRoute }}" class="gradient-bg-primary text-white font-bold text-xs sm:text-sm px-5 py-2.5 rounded-full shadow-lg shadow-indigo-600/30 hover:opacity-95 transition flex items-center gap-2">
                        <i class="fa-solid fa-user-gear"></i>
                        <span>Mon Espace ({{ ucfirst(auth()->user()->role) }})</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="gradient-bg-primary text-white font-bold text-xs sm:text-sm px-6 py-2.5 rounded-full shadow-lg shadow-indigo-600/30 hover:opacity-95 transition flex items-center gap-2">
                        <i class="fa-solid fa-user"></i>
                        <span>Se connecter</span>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Section (Split Layout) -->
    <section class="relative pt-10 pb-16 lg:pt-16 lg:pb-24 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                
                <!-- Left Content -->
                <div class="lg:col-span-6 space-y-6 text-left">
                    
                    <!-- Top Pill -->
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-300 text-xs sm:text-sm font-semibold">
                        <i class="fa-solid fa-wand-magic-sparkles text-indigo-400"></i>
                        <span>Une solution intelligente pour un meilleur suivi</span>
                    </div>

                    <!-- Main Headline -->
                    <h1 class="text-3xl sm:text-5xl lg:text-5xl xl:text-6xl font-extrabold text-white tracking-tight leading-[1.15]">
                        Suivi des stagiaires <br class="hidden sm:inline" />
                        <span class="gradient-text">assisté par l'IA</span>
                    </h1>

                    <!-- Description -->
                    <p class="text-slate-400 text-sm sm:text-base lg:text-lg leading-relaxed max-w-xl">
                        Une plateforme moderne pour gérer, suivre et évaluer les stagiaires de manière simple, efficace et intelligente.
                    </p>

                    <!-- Feature Badges Pill Row -->
                    <div class="flex flex-wrap items-center gap-2.5 pt-1">
                        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-900 border border-slate-800 text-xs font-semibold text-slate-200">
                            <i class="fa-solid fa-location-dot text-indigo-400"></i> Géolocalisation
                        </span>
                        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-900 border border-slate-800 text-xs font-semibold text-slate-200">
                            <i class="fa-solid fa-brain text-purple-400"></i> Intelligence artificielle
                        </span>
                        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-900 border border-slate-800 text-xs font-semibold text-slate-200">
                            <i class="fa-solid fa-clock text-cyan-400"></i> Suivi en temps réel
                        </span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 pt-3">
                        <a href="{{ route('demande.form') }}" class="gradient-bg-primary text-white font-bold text-sm sm:text-base px-7 py-3.5 rounded-full shadow-xl shadow-indigo-600/30 hover:opacity-95 transition flex items-center justify-center gap-3">
                            <i class="fa-solid fa-rocket"></i> Commencer maintenant
                        </a>
                        <a href="{{ route('login') }}" class="bg-slate-900/90 hover:bg-slate-800 text-slate-200 border border-slate-700 font-semibold text-sm sm:text-base px-7 py-3.5 rounded-full transition flex items-center justify-center gap-3">
                            <i class="fa-solid fa-play text-xs"></i> Accéder à l'espace
                        </a>
                    </div>
                </div>

                <!-- Right Side Showcase Image (Exact image fournie par l'utilisateur) -->
                <div class="lg:col-span-6 relative flex justify-center items-center">
                    <div class="relative group">
                        <div class="absolute -inset-1.5 gradient-bg-primary rounded-3xl blur-xl opacity-25 group-hover:opacity-40 transition duration-500"></div>
                        <img src="{{ asset('images/hero-showcase.png') }}" alt="SuiviStagiaires Application Showcase" class="relative w-full h-auto rounded-3xl border border-slate-800/90 shadow-2xl shadow-indigo-950/80 object-cover transform hover:scale-[1.01] transition duration-300">
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- "Nos Atouts" Section (5 Feature Cards Row inspirée de l'image de référence) -->
    <section id="atouts" class="py-16 sm:py-24 bg-slate-900/50 border-y border-slate-800/80 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto space-y-3">
                <span class="px-4 py-1.5 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-300 text-xs font-bold uppercase tracking-wider">
                    Nos atouts
                </span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight">
                    Une solution complète et performante
                </h2>
                <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                    Des fonctionnalités pensées pour simplifier la gestion des stages et améliorer l'expérience de tous les acteurs.
                </p>
            </div>

            <!-- 5 Column Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-5">
                
                <!-- Card 1 -->
                <div class="glass-panel p-6 rounded-2xl border border-slate-800 space-y-4 hover:border-indigo-500/40 hover:scale-[1.02] transition duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <h3 class="font-bold text-base text-white">Gestion des stagiaires</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Ajoutez, modifiez et suivez facilement les informations et profils de tous vos stagiaires.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="glass-panel p-6 rounded-2xl border border-slate-800 space-y-4 hover:border-purple-500/40 hover:scale-[1.02] transition duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-purple-500/10 border border-purple-500/20 text-purple-400 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <h3 class="font-bold text-base text-white">Suivi des stages & activités</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Organisez les stages, attribuez les tâches et suivez l'évolution des activités au quotidien.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="glass-panel p-6 rounded-2xl border border-slate-800 space-y-4 hover:border-cyan-500/40 hover:scale-[1.02] transition duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <h3 class="font-bold text-base text-white">Géolocalisation</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Vérifiez la position des stagiaires et assurez un contrôle fiable et précis des présences.
                    </p>
                </div>

                <!-- Card 4 -->
                <div class="glass-panel p-6 rounded-2xl border border-slate-800 space-y-4 hover:border-emerald-500/40 hover:scale-[1.02] transition duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-brain"></i>
                    </div>
                    <h3 class="font-bold text-base text-white">Intelligence artificielle</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Analysez les bilans, détectez les blocages et bénéficiez d'un assistant intelligent de synthèse.
                    </p>
                </div>

                <!-- Card 5 -->
                <div class="glass-panel p-6 rounded-2xl border border-slate-800 space-y-4 hover:border-amber-500/40 hover:scale-[1.02] transition duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h3 class="font-bold text-base text-white">Rapports & statistiques</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Générez des rapports et des tableaux de bord interactifs pour une prise de décision optimale.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <!-- Stats Counter Bar (Inspirée de la bande du bas de la référence) -->
    <section class="py-10 gradient-bg-primary text-white relative overflow-hidden shadow-2xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center divide-y md:divide-y-0 md:divide-x divide-white/20">
                
                <div class="p-4 flex flex-col items-center justify-center space-y-1">
                    <div class="flex items-center gap-2 text-2xl sm:text-3xl font-extrabold">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <span>+100</span>
                    </div>
                    <p class="text-xs sm:text-sm font-semibold opacity-90">Stagiaires suivis</p>
                </div>

                <div class="p-4 flex flex-col items-center justify-center space-y-1">
                    <div class="flex items-center gap-2 text-2xl sm:text-3xl font-extrabold">
                        <i class="fa-solid fa-building"></i>
                        <span>+20</span>
                    </div>
                    <p class="text-xs sm:text-sm font-semibold opacity-90">Structures d'accueil</p>
                </div>

                <div class="p-4 flex flex-col items-center justify-center space-y-1">
                    <div class="flex items-center gap-2 text-2xl sm:text-3xl font-extrabold">
                        <i class="fa-solid fa-shield-check"></i>
                        <span>100%</span>
                    </div>
                    <p class="text-xs sm:text-sm font-semibold opacity-90">Sécurisé et fiable</p>
                </div>

                <div class="p-4 flex flex-col items-center justify-center space-y-1">
                    <div class="flex items-center gap-2 text-2xl sm:text-3xl font-extrabold">
                        <i class="fa-solid fa-bolt"></i>
                        <span>Disponible</span>
                    </div>
                    <p class="text-xs sm:text-sm font-semibold opacity-90">Partout, tout le temps</p>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-slate-950 border-t border-slate-800/80 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-400">
            
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg gradient-bg-primary flex items-center justify-center text-white text-xs font-bold">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <span class="font-bold text-slate-200">SuiviStagiaires</span>
                <span>&copy; {{ date('Y') }} — Tous droits réservés.</span>
            </div>

            <div class="flex items-center gap-6">
                <a href="{{ route('demande.form') }}" class="hover:text-indigo-400 transition">Demande de stage</a>
                <a href="{{ route('login') }}" class="hover:text-indigo-400 transition">Connexion</a>
                <a href="{{ route('password.request') }}" class="hover:text-indigo-400 transition">Mot de passe oublié</a>
            </div>

        </div>
    </footer>

</body>
</html>
