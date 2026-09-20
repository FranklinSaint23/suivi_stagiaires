<!DOCTYPE html>
<html lang="fr" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuiviStagiaires AI — Solution Intelligente de Suivi des Stages</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f8f9fe] text-slate-800 font-sans antialiased selection:bg-indigo-500 selection:text-white">

    <!-- Subtle Ambient Background Accents -->
    <div class="fixed top-0 right-0 w-[600px] h-[600px] bg-gradient-to-b from-indigo-200/40 to-purple-200/20 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="fixed top-1/2 left-0 w-[500px] h-[500px] bg-gradient-to-r from-purple-100/40 to-indigo-100/20 rounded-full blur-[140px] pointer-events-none"></div>

    <!-- Top Navigation Header -->
    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-indigo-100/60 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
            
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 shrink-0 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center text-white shadow-md shadow-indigo-500/20 group-hover:scale-105 transition duration-300">
                    <i class="fa-solid fa-graduation-cap text-xl"></i>
                </div>
                <span class="font-extrabold text-xl tracking-tight text-slate-900">
                    SuiviStagiaires <span class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-[11px] font-extrabold px-2 py-0.5 rounded-md uppercase tracking-wider shadow-sm ml-1">AI</span>
                </span>
            </a>

            <!-- Center Navigation Links -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600">
                <a href="{{ url('/') }}" class="text-indigo-600 relative py-1 font-bold border-b-2 border-indigo-600">Accueil</a>
                <a href="#atouts" class="hover:text-indigo-600 transition">Fonctionnalités</a>
                <a href="#processus" class="hover:text-indigo-600 transition">À propos</a>
                <a href="#contact" class="hover:text-indigo-600 transition">Contact</a>
            </nav>

            <!-- Action Button -->
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
                    <a href="{{ $targetRoute }}" class="bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-700 hover:opacity-95 text-white font-bold text-xs sm:text-sm px-6 py-2.5 rounded-full shadow-lg shadow-indigo-500/25 transition flex items-center gap-2">
                        <i class="fa-solid fa-user text-sm"></i> Mon Espace
                    </a>
                @else
                    <a href="{{ route('login') }}" class="bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-700 hover:opacity-95 text-white font-bold text-xs sm:text-sm px-6 py-2.5 rounded-full shadow-lg shadow-indigo-500/25 transition flex items-center gap-2">
                        <i class="fa-solid fa-user text-sm"></i> Se connecter
                    </a>
                @endauth
            </div>

        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative pt-8 pb-16 lg:pt-14 lg:pb-24 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Left Column (Content & CTAs) -->
                <div class="lg:col-span-6 space-y-6 text-left">
                    
                    <!-- Soft Top Pill -->
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-50 border border-indigo-200/80 text-indigo-700 text-xs sm:text-sm font-semibold shadow-xs">
                        <i class="fa-solid fa-wand-magic-sparkles text-indigo-500"></i>
                        <span>Une solution intelligente pour un meilleur suivi</span>
                    </div>

                    <!-- Main Headline -->
                    <h1 class="text-3xl sm:text-5xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-[1.15]">
                        Suivi des stagiaires <span class="bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-800 bg-clip-text text-transparent">assisté par l'IA</span>
                    </h1>

                    <!-- Description -->
                    <p class="text-base sm:text-lg text-slate-600 leading-relaxed font-normal">
                        Une plateforme moderne pour gérer, suivre et évaluer les stagiaires de manière simple, efficace et intelligente.
                    </p>

                    <!-- Feature Tags Row -->
                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        <div class="flex items-center gap-2 bg-white border border-indigo-100 shadow-xs rounded-full px-3.5 py-1.5 text-xs font-bold text-slate-700">
                            <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center"><i class="fa-solid fa-location-dot text-xs"></i></span>
                            Géolocalisation
                        </div>
                        <div class="flex items-center gap-2 bg-white border border-purple-100 shadow-xs rounded-full px-3.5 py-1.5 text-xs font-bold text-slate-700">
                            <span class="w-6 h-6 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center"><i class="fa-solid fa-brain text-xs"></i></span>
                            Intelligence artificielle
                        </div>
                        <div class="flex items-center gap-2 bg-white border border-indigo-100 shadow-xs rounded-full px-3.5 py-1.5 text-xs font-bold text-slate-700">
                            <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center"><i class="fa-solid fa-clock text-xs"></i></span>
                            Suivi en temps réel
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="pt-4 flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                        <a href="{{ route('demande.form') }}" class="bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-700 hover:opacity-95 text-white font-bold text-sm px-8 py-3.5 rounded-full shadow-xl shadow-indigo-500/30 transition flex items-center justify-center gap-2.5">
                            <i class="fa-solid fa-rocket"></i> Commencer maintenant
                        </a>
                        <a href="{{ route('login') }}" class="bg-white hover:bg-slate-50 text-slate-700 border-2 border-slate-200/90 font-bold text-sm px-7 py-3.5 rounded-full transition flex items-center justify-center gap-2.5 shadow-xs">
                            <i class="fa-solid fa-play text-indigo-600 text-xs"></i> Voir la présentation
                        </a>
                    </div>

                </div>

                <!-- Right Column (Interactive Dashboard Visual Mockup) -->
                <div class="lg:col-span-6 relative">
                    
                    <!-- Floating Speech Bubble AI Assistant -->
                    <div class="absolute -top-6 left-6 z-20 bg-white rounded-2xl p-3 shadow-xl border border-indigo-100 flex items-center gap-3 max-w-xs animate-bounce" style="animation-duration: 4s;">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-600 to-purple-600 text-white flex items-center justify-center text-lg shrink-0 shadow-md">
                            <i class="fa-solid fa-robot"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 block">IA Assistant</span>
                            <p class="text-xs text-slate-700 font-medium">Je suis votre assistant intelligent. Comment puis-je vous aider ?</p>
                        </div>
                    </div>

                    <!-- Floating Geolocation Route Badge -->
                    <div class="absolute top-10 -right-2 sm:-right-6 z-20 bg-indigo-950 text-white rounded-full px-4 py-2 shadow-xl border border-indigo-500/30 flex items-center gap-2 text-xs font-semibold">
                        <i class="fa-solid fa-location-dot text-indigo-400 animate-pulse"></i>
                        <span>Position en temps réel</span>
                    </div>

                    <!-- Floating Security Badge -->
                    <div class="absolute -bottom-4 left-10 z-20 bg-white rounded-2xl px-4 py-2.5 shadow-xl border border-slate-100 flex items-center gap-2 text-xs font-bold text-slate-800">
                        <span class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center"><i class="fa-solid fa-shield-halved"></i></span>
                        Une gestion sécurisée et fiable
                    </div>

                    <!-- Main Dashboard Mockup Card -->
                    <div class="bg-white rounded-3xl p-4 sm:p-6 shadow-2xl border border-indigo-100/80 relative z-10 overflow-hidden transform lg:rotate-1 hover:rotate-0 transition duration-500">
                        
                        <!-- Mockup Top Bar -->
                        <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-lg bg-indigo-600 text-white flex items-center justify-center text-xs font-bold">
                                    <i class="fa-solid fa-graduation-cap"></i>
                                </div>
                                <span class="font-bold text-slate-800 text-xs">SuiviStagiaires</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-400">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span> En direct
                            </div>
                        </div>

                        <!-- Mockup Dashboard Layout Grid -->
                        <div class="grid grid-cols-12 gap-4">
                            <!-- Sidebar Mockup -->
                            <div class="col-span-3 bg-slate-50 p-2.5 rounded-2xl space-y-2 hidden sm:block text-[11px] font-medium text-slate-600">
                                <div class="p-2 rounded-xl bg-indigo-600 text-white font-bold flex items-center gap-1.5"><i class="fa-solid fa-gauge text-xs"></i> Dashboard</div>
                                <div class="p-1.5 rounded-lg hover:bg-slate-200/60 flex items-center gap-1.5"><i class="fa-solid fa-users text-xs text-indigo-500"></i> Stagiaires</div>
                                <div class="p-1.5 rounded-lg hover:bg-slate-200/60 flex items-center gap-1.5"><i class="fa-solid fa-briefcase text-xs text-purple-500"></i> Stages</div>
                                <div class="p-1.5 rounded-lg hover:bg-slate-200/60 flex items-center gap-1.5"><i class="fa-solid fa-calendar-check text-xs text-emerald-500"></i> Présences</div>
                                <div class="p-1.5 rounded-lg hover:bg-slate-200/60 flex items-center gap-1.5"><i class="fa-solid fa-chart-line text-xs text-amber-500"></i> Évaluations</div>
                            </div>

                            <!-- Dashboard Content Mockup -->
                            <div class="col-span-12 sm:col-span-9 space-y-3">
                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm">Bonjour !</h4>
                                    <p class="text-[11px] text-slate-400">Voici un aperçu de votre activité.</p>
                                </div>

                                <!-- Metric Pill Cards -->
                                <div class="grid grid-cols-3 gap-2">
                                    <div class="bg-indigo-50/60 p-2.5 rounded-xl border border-indigo-100">
                                        <span class="text-[10px] text-slate-500 block">Stagiaires</span>
                                        <span class="font-extrabold text-indigo-700 text-base">48</span>
                                        <span class="text-[9px] text-emerald-600 font-bold">↑ 12%</span>
                                    </div>

                                    <div class="bg-purple-50/60 p-2.5 rounded-xl border border-purple-100">
                                        <span class="text-[10px] text-slate-500 block">Stages en cours</span>
                                        <span class="font-extrabold text-purple-700 text-base">32</span>
                                        <span class="text-[9px] text-emerald-600 font-bold">↑ 8%</span>
                                    </div>

                                    <div class="bg-emerald-50/60 p-2.5 rounded-xl border border-emerald-100">
                                        <span class="text-[10px] text-slate-500 block">Présences</span>
                                        <span class="font-extrabold text-emerald-700 text-base">41</span>
                                        <span class="text-[9px] text-emerald-600 font-bold">↑ 5%</span>
                                    </div>
                                </div>

                                <!-- Mini Chart Representation -->
                                <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 space-y-2">
                                    <div class="flex justify-between items-center text-[10px] font-bold text-slate-600">
                                        <span>Évolution des présences</span>
                                        <span class="text-indigo-600">Temps réel</span>
                                    </div>
                                    <div class="h-16 flex items-end justify-between gap-1.5 pt-2 px-1">
                                        <div class="w-full bg-indigo-200 rounded-t h-[40%]"></div>
                                        <div class="w-full bg-indigo-300 rounded-t h-[65%]"></div>
                                        <div class="w-full bg-indigo-400 rounded-t h-[50%]"></div>
                                        <div class="w-full bg-indigo-500 rounded-t h-[85%]"></div>
                                        <div class="w-full bg-indigo-600 rounded-t h-[95%]"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- Section Nos Atouts -->
    <section id="atouts" class="py-20 bg-white border-y border-indigo-100/60 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="inline-block bg-indigo-50 text-indigo-600 text-xs font-extrabold uppercase tracking-widest px-4 py-1.5 rounded-full border border-indigo-100">
                    Nos atouts
                </span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Une solution complète et performante
                </h2>
                <p class="text-sm sm:text-base text-slate-500">
                    Des fonctionnalités pensées pour simplifier la gestion des stages et améliorer l'expérience de tous les acteurs.
                </p>
            </div>

            <!-- 5 Features Cards Row/Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
                
                <!-- Card 1 -->
                <div class="bg-[#f8f9fe] p-6 rounded-2xl border border-indigo-100/80 hover:border-indigo-400 transition duration-300 hover:shadow-lg space-y-3 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl font-bold mb-4 shadow-sm">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 text-base mb-2">Gestion des stagiaires</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Ajoutez, modifiez et suivez facilement les informations des stagiaires.
                        </p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-[#f8f9fe] p-6 rounded-2xl border border-indigo-100/80 hover:border-indigo-400 transition duration-300 hover:shadow-lg space-y-3 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl font-bold mb-4 shadow-sm">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 text-base mb-2">Suivi des stages et activités</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Organisez les stages, attribuez les tâches et suivez l'évolution des activités.
                        </p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-[#f8f9fe] p-6 rounded-2xl border border-indigo-100/80 hover:border-indigo-400 transition duration-300 hover:shadow-lg space-y-3 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl font-bold mb-4 shadow-sm">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 text-base mb-2">Géolocalisation</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Vérifiez la position des stagiaires et assurez un meilleur contrôle des présences.
                        </p>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="bg-[#f8f9fe] p-6 rounded-2xl border border-indigo-100/80 hover:border-indigo-400 transition duration-300 hover:shadow-lg space-y-3 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl font-bold mb-4 shadow-sm">
                            <i class="fa-solid fa-brain"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 text-base mb-2">Intelligence artificielle</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Analysez les données, détectez les anomalies et bénéficiez d'un assistant intelligent.
                        </p>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="bg-[#f8f9fe] p-6 rounded-2xl border border-indigo-100/80 hover:border-indigo-400 transition duration-300 hover:shadow-lg space-y-3 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl font-bold mb-4 shadow-sm">
                            <i class="fa-solid fa-chart-column"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 text-base mb-2">Rapports et statistiques</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Générez des rapports et des tableaux de bord pour une meilleure prise de décision.
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- Bottom Stat Banner (Dark Purple Bar) -->
    <section class="bg-gradient-to-r from-indigo-950 via-purple-950 to-indigo-900 text-white py-12 border-t border-indigo-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                
                <div class="flex flex-col items-center justify-center space-y-1">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-graduation-cap text-2xl text-indigo-400"></i>
                        <span class="text-3xl font-extrabold text-white">+100</span>
                    </div>
                    <span class="text-xs text-slate-300 font-medium">Stagiaires suivis</span>
                </div>

                <div class="flex flex-col items-center justify-center space-y-1">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-building text-2xl text-indigo-400"></i>
                        <span class="text-3xl font-extrabold text-white">+20</span>
                    </div>
                    <span class="text-xs text-slate-300 font-medium">Structures d'accueil</span>
                </div>

                <div class="flex flex-col items-center justify-center space-y-1">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-shield-halved text-2xl text-emerald-400"></i>
                        <span class="text-3xl font-extrabold text-white">100%</span>
                    </div>
                    <span class="text-xs text-slate-300 font-medium">Sécurisé et fiable</span>
                </div>

                <div class="flex flex-col items-center justify-center space-y-1">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-bolt text-2xl text-amber-400"></i>
                        <span class="text-3xl font-extrabold text-white">Disponible</span>
                    </div>
                    <span class="text-xs text-slate-300 font-medium">partout, tout le temps</span>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-lg bg-gradient-to-tr from-indigo-600 to-purple-600 text-white flex items-center justify-center text-[10px] font-bold">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <span class="font-bold text-slate-800">SuiviStagiaires AI</span>
                <span>&copy; {{ date('Y') }} — Tous droits réservés.</span>
            </div>

            <div class="flex items-center gap-6 font-semibold">
                <a href="{{ route('demande.form') }}" class="hover:text-indigo-600 transition">Demande de stage</a>
                <a href="{{ route('login') }}" class="hover:text-indigo-600 transition">Connexion</a>
                <a href="{{ route('password.request') }}" class="hover:text-indigo-600 transition">Mot de passe oublié</a>
            </div>
        </div>
    </footer>

</body>
</html>
