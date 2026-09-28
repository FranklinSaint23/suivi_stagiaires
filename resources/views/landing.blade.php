<!DOCTYPE html>
<html lang="fr" class="dark h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StageTrack — Suivi des Stagiaires Assisté par l'IA et Géolocalisation</title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        // Inline Theme Initializer
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
<body class="min-h-screen bg-slate-50 dark:bg-[#090d16] text-slate-900 dark:text-slate-100 font-sans antialiased selection:bg-indigo-500 selection:text-white overflow-x-hidden transition-colors duration-300">

    <!-- Ambient Glow Backgrounds -->
    <div class="fixed -top-40 -left-40 w-[600px] h-[600px] bg-indigo-500/10 dark:bg-indigo-600/15 rounded-full blur-[140px] pointer-events-none z-0 animate-pulse-glow"></div>
    <div class="fixed top-1/3 -right-40 w-[550px] h-[550px] bg-purple-500/10 dark:bg-purple-600/15 rounded-full blur-[140px] pointer-events-none z-0 animate-pulse-glow" style="animation-delay: 3s;"></div>

    <!-- Navigation Header -->
    <header class="sticky top-0 z-50 bg-white/80 dark:bg-[#090d16]/85 backdrop-blur-xl border-b border-slate-200/80 dark:border-slate-800/80 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
            
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 shrink-0 group">
                <div class="w-11 h-11 rounded-2xl gradient-bg-primary flex items-center justify-center shadow-lg shadow-indigo-500/25 group-hover:scale-105 transition duration-300">
                    <i class="fa-solid fa-graduation-cap text-2xl text-white"></i>
                </div>
                <div class="flex flex-col">
                    <span class="font-black text-2xl tracking-tight text-slate-900 dark:text-white flex items-center gap-1">
                        Stage<span class="gradient-text">Track</span>
                    </span>
                    <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest -mt-1">
                        IA • Géolocalisation • Réussite
                    </span>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center gap-7 text-sm font-semibold text-slate-600 dark:text-slate-300">
                <a href="{{ url('/') }}" class="px-3 py-1.5 rounded-full bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-bold">Accueil</a>
                <a href="#features" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Fonctionnalités</a>
                <a href="#impact" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Tarifs</a>
            </nav>

            <!-- Actions Right (Dark Mode Toggle & Login) -->
            <div class="flex items-center gap-3 shrink-0">
                
                <!-- Dark / Light Mode Switcher Button -->
                <button onclick="toggleTheme()" type="button" title="Changer le mode sombre/clair" 
                        class="p-2.5 rounded-full text-slate-600 dark:text-slate-300 hover:text-amber-500 dark:hover:text-amber-400 bg-slate-100 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/80 transition-all duration-200 hover:scale-110 shadow-sm flex items-center justify-center">
                    <i class="fa-solid fa-sun text-amber-400 text-base hidden dark:inline"></i>
                    <i class="fa-solid fa-moon text-indigo-600 text-base dark:hidden"></i>
                </button>

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
                    <a href="{{ route('login') }}" class="gradient-bg-primary text-white font-bold text-xs sm:text-sm px-5 py-2.5 rounded-full shadow-lg shadow-indigo-600/30 hover:opacity-95 transition flex items-center gap-2">
                        <i class="fa-solid fa-right-to-bracket text-sm"></i>
                        <span>Se connecter</span>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="relative pt-8 pb-16 lg:pt-14 lg:pb-24 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                
                <!-- Hero Left Content -->
                <div class="lg:col-span-6 space-y-6 text-left">
                    
                    <!-- Innovation Badge -->
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-200 dark:border-indigo-500/20 text-indigo-600 dark:text-indigo-300 text-xs sm:text-sm font-semibold shadow-sm">
                        <span class="text-indigo-500">✦</span>
                        <span>Une solution innovante pour un meilleur encadrement</span>
                    </div>

                    <!-- Title -->
                    <h1 class="text-3xl sm:text-5xl lg:text-5xl xl:text-6xl font-black tracking-tight leading-[1.15] text-slate-900 dark:text-white">
                        Suivi de stagiaires <br />
                        <span class="gradient-text">assisté par l'IA</span> <br />
                        et géolocalisation
                    </h1>

                    <!-- Paragraph -->
                    <p class="text-slate-600 dark:text-slate-400 text-sm sm:text-base lg:text-lg leading-relaxed max-w-xl">
                        Une plateforme intelligente qui simplifie la gestion et le suivi des stagiaires. Grâce à l'IA et à la géolocalisation, vous avez une vision claire, en temps réel, de leur progression, de leur présence et de leurs performances.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 pt-2">
                        <a href="{{ route('demande.form') }}" class="gradient-bg-primary text-white font-bold text-sm sm:text-base px-7 py-3.5 rounded-full shadow-xl shadow-indigo-600/30 hover:opacity-95 transition flex items-center justify-center gap-3 transform hover:scale-[1.02]">
                            <span>🚀 Commencer maintenant</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                        <a href="#features" class="bg-white dark:bg-slate-900/90 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-800 dark:text-slate-200 border border-slate-300 dark:border-slate-700 font-semibold text-sm sm:text-base px-7 py-3.5 rounded-full shadow-sm transition flex items-center justify-center gap-3">
                            <i class="fa-solid fa-circle-play text-indigo-600 dark:text-indigo-400 text-lg"></i>
                            <span>Découvrir l'application</span>
                            <i class="fa-solid fa-arrow-right text-xs opacity-60"></i>
                        </a>
                    </div>
                </div>

                <!-- Hero Right Visual Mockup (Matching Image Reference Perfectly) -->
                <div class="lg:col-span-6 relative flex justify-center items-center mt-6 lg:mt-0">
                    <div class="relative w-full max-w-xl">
                        
                        <!-- Glowing backdrop aura -->
                        <div class="absolute -inset-2 gradient-bg-primary rounded-3xl blur-2xl opacity-20 dark:opacity-30"></div>
                        
                        <!-- Main Hero Image (African Interns Collaborating on Laptop) -->
                        <div class="relative rounded-3xl overflow-hidden border-4 border-white dark:border-slate-800 shadow-2xl group">
                            <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=1200&q=80" 
                                 alt="Stagiaires africains travaillant en équipe" 
                                 class="w-full h-[360px] sm:h-[440px] object-cover transform group-hover:scale-105 transition duration-700">
                            
                            <!-- Dark Gradient overlay at bottom -->
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent"></div>
                        </div>

                        <!-- FLOATING BADGE 1: AI Assistant Bot (Bottom Center / Left) -->
                        <div class="absolute -bottom-6 left-4 sm:left-6 z-20 bg-white dark:bg-slate-900/95 border border-slate-200 dark:border-slate-800 p-3.5 sm:p-4 rounded-2xl shadow-xl backdrop-blur-md flex items-center gap-3 animate-float-slow">
                            <div class="w-12 h-12 rounded-xl gradient-bg-primary flex items-center justify-center text-white text-xl shadow-md shadow-indigo-500/30">
                                <i class="fa-solid fa-robot text-2xl"></i>
                            </div>
                            <div class="text-xs space-y-0.5">
                                <div class="px-2 py-1 rounded-lg bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-extrabold flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                                    <span>Analyse des données</span>
                                </div>
                                <p class="text-slate-600 dark:text-slate-300 font-semibold pl-1">Recommandations & Suivi personnalisé</p>
                            </div>
                        </div>

                        <!-- FLOATING CARD 2: Geoloc Live Tracking Widget (Top Right) -->
                        <div class="absolute -top-6 -right-2 sm:-right-6 z-20 w-64 sm:w-72 bg-white/95 dark:bg-slate-900/95 border border-slate-200 dark:border-slate-800 p-4 rounded-2xl shadow-2xl backdrop-blur-md animate-float-reverse">
                            <div class="flex items-center gap-3 pb-3 border-b border-slate-200 dark:border-slate-800">
                                <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=150&q=80" 
                                     alt="Photo Stagiaire" 
                                     class="w-10 h-10 rounded-full object-cover border-2 border-indigo-500">
                                <div>
                                    <h4 class="font-bold text-xs text-slate-900 dark:text-white">Stagiaire</h4>
                                    <span class="inline-flex items-center gap-1 text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse-dot"></span> En stage
                                    </span>
                                </div>
                            </div>
                            <div class="py-2.5 text-[11px] text-slate-500 dark:text-slate-400 font-medium space-y-1">
                                <div class="flex items-center gap-1.5 text-indigo-600 dark:text-indigo-400 font-bold">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <span>Position actuelle</span>
                                </div>
                                <p class="font-mono text-[10px] text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-800/80 p-1.5 rounded-lg border border-slate-200 dark:border-slate-700/50">4.0511° N, 9.7679° E</p>
                            </div>
                            <div class="space-y-1.5 pt-1 text-[11px] font-semibold text-slate-700 dark:text-slate-300">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                                    <span>Présence validée</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                                    <span>Lieu conforme</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                                    <span>Suivi en temps réel</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- FEATURES SECTION ("— Nos fonctionnalités") -->
    <section id="features" class="py-16 sm:py-24 bg-slate-100/70 dark:bg-slate-900/40 border-y border-slate-200 dark:border-slate-800/80 relative transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            
            <!-- Section Header -->
            <div class="text-left max-w-2xl space-y-2">
                <span class="text-indigo-600 dark:text-indigo-400 text-sm font-extrabold uppercase tracking-wider block">
                    — Nos fonctionnalités
                </span>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white tracking-tight">
                    Tout ce dont vous avez besoin, au même endroit
                </h2>
                <p class="text-slate-600 dark:text-slate-400 text-sm sm:text-base leading-relaxed">
                    Une plateforme complète et intuitive pour gérer efficacement vos stagiaires, de leur inscription à leur évaluation finale.
                </p>
            </div>

            <!-- 6 Grid Feature Cards (Identical Layout to Mockup) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-5">
                
                <!-- Feature 1: Gestion des stagiaires -->
                <div class="lg:col-span-1 glass-panel p-6 rounded-2xl border border-slate-200 dark:border-slate-800/90 space-y-4 hover:shadow-xl hover:border-indigo-500/50 hover:-translate-y-1 transition duration-300 bg-white dark:bg-slate-900/70">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xl font-bold">
                        <i class="fa-solid fa-users text-indigo-500"></i>
                    </div>
                    <h3 class="font-black text-base text-slate-900 dark:text-white">Gestion des stagiaires</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Inscription, suivi des dossiers, répartition des stages et formations.
                    </p>
                </div>

                <!-- Feature 2: Assistance IA -->
                <div class="lg:col-span-1 glass-panel p-6 rounded-2xl border border-slate-200 dark:border-slate-800/90 space-y-4 hover:shadow-xl hover:border-purple-500/50 hover:-translate-y-1 transition duration-300 bg-white dark:bg-slate-900/70">
                    <div class="w-12 h-12 rounded-2xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center text-xl font-bold">
                        <i class="fa-solid fa-brain text-purple-500"></i>
                    </div>
                    <h3 class="font-black text-base text-slate-900 dark:text-white">Assistance IA</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Analyse des CV, évaluation des performances et recommandations personnalisées.
                    </p>
                </div>

                <!-- Feature 3: Géolocalisation -->
                <div class="lg:col-span-1 glass-panel p-6 rounded-2xl border border-slate-200 dark:border-slate-800/90 space-y-4 hover:shadow-xl hover:border-emerald-500/50 hover:-translate-y-1 transition duration-300 bg-white dark:bg-slate-900/70">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl font-bold">
                        <i class="fa-solid fa-location-dot text-emerald-500"></i>
                    </div>
                    <h3 class="font-black text-base text-slate-900 dark:text-white">Géolocalisation</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Suivi en temps réel de la position des stagiaires et contrôle des présences.
                    </p>
                </div>

                <!-- Feature 4: Suivi des présences -->
                <div class="lg:col-span-1 glass-panel p-6 rounded-2xl border border-slate-200 dark:border-slate-800/90 space-y-4 hover:shadow-xl hover:border-amber-500/50 hover:-translate-y-1 transition duration-300 bg-white dark:bg-slate-900/70">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xl font-bold">
                        <i class="fa-solid fa-clock text-amber-500"></i>
                    </div>
                    <h3 class="font-black text-base text-slate-900 dark:text-white">Suivi des présences</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Pointage, historique et alertes en cas d'anomalie.
                    </p>
                </div>

                <!-- Feature 5: Évaluations & Rapports -->
                <div class="lg:col-span-1 glass-panel p-6 rounded-2xl border border-slate-200 dark:border-slate-800/90 space-y-4 hover:shadow-xl hover:border-violet-500/50 hover:-translate-y-1 transition duration-300 bg-white dark:bg-slate-900/70">
                    <div class="w-12 h-12 rounded-2xl bg-violet-500/10 text-violet-600 dark:text-violet-400 flex items-center justify-center text-xl font-bold">
                        <i class="fa-solid fa-chart-column text-violet-500"></i>
                    </div>
                    <h3 class="font-black text-base text-slate-900 dark:text-white">Évaluations & Rapports</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Évaluations, rapports de stage et statistiques détaillées.
                    </p>
                </div>

                <!-- Feature 6: Sécurité & Accès -->
                <div class="lg:col-span-1 glass-panel p-6 rounded-2xl border border-slate-200 dark:border-slate-800/90 space-y-4 hover:shadow-xl hover:border-teal-500/50 hover:-translate-y-1 transition duration-300 bg-white dark:bg-slate-900/70">
                    <div class="w-12 h-12 rounded-2xl bg-teal-500/10 text-teal-600 dark:text-teal-400 flex items-center justify-center text-xl font-bold">
                        <i class="fa-solid fa-shield-halved text-teal-500"></i>
                    </div>
                    <h3 class="font-black text-base text-slate-900 dark:text-white">Sécurité & Gestion des accès</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Rôles (admin, encadrant, stagiaire) et protection des données.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <!-- IMPACT SECTION ("UN IMPACT RÉEL") -->
    <section id="impact" class="py-16 sm:py-24 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Impact Left Text & Metrics -->
                <div class="lg:col-span-6 space-y-6">
                    <span class="text-indigo-600 dark:text-indigo-400 text-xs font-black uppercase tracking-widest block">
                        UN IMPACT RÉEL
                    </span>
                    <h2 class="text-3xl sm:text-5xl font-black text-slate-900 dark:text-white tracking-tight leading-tight">
                        Des stagiaires mieux encadrés, <br />
                        un avenir plus solide !
                    </h2>
                    <p class="text-slate-600 dark:text-slate-400 text-sm sm:text-base leading-relaxed">
                        Notre solution accompagne les entreprises, les encadreurs et les stagiaires pour une expérience de stage plus efficace, plus transparente et plus enrichissante.
                    </p>

                    <!-- Metrics Badges (Exact icons and text from image) -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4">
                        
                        <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm">
                            <div class="w-10 h-10 rounded-xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center text-lg font-bold shrink-0">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div>
                                <span class="text-lg font-black text-slate-900 dark:text-white block">+ 500</span>
                                <span class="text-[11px] text-slate-500 dark:text-slate-400 font-semibold">Stagiaires suivis</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm">
                            <div class="w-10 h-10 rounded-xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-lg font-bold shrink-0">
                                <i class="fa-solid fa-building-columns"></i>
                            </div>
                            <div>
                                <span class="text-lg font-black text-slate-900 dark:text-white block">+ 50</span>
                                <span class="text-[11px] text-slate-500 dark:text-slate-400 font-semibold">Entreprises partenaires</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm">
                            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-lg font-bold shrink-0">
                                <i class="fa-solid fa-bullseye"></i>
                            </div>
                            <div>
                                <span class="text-lg font-black text-slate-900 dark:text-white block">95%</span>
                                <span class="text-[11px] text-slate-500 dark:text-slate-400 font-semibold">Taux de satisfaction</span>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Impact Right Showcase & Dark CTA Container -->
                <div class="lg:col-span-6 relative flex flex-col items-center">
                    
                    <!-- Dashboard Mockups (Laptop + Smartphone) -->
                    <div class="relative w-full mb-8">
                        <div class="relative mx-auto max-w-lg rounded-2xl border-4 border-slate-800 dark:border-slate-700 bg-slate-900 p-2 shadow-2xl">
                            <!-- Simulated StageTrack App Screen -->
                            <div class="rounded-xl overflow-hidden bg-slate-950 p-4 space-y-3">
                                <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-lg gradient-bg-primary flex items-center justify-center text-white text-xs">
                                            <i class="fa-solid fa-graduation-cap"></i>
                                        </div>
                                        <span class="text-xs font-bold text-white">StageTrack Dashboard</span>
                                    </div>
                                    <span class="text-[10px] bg-indigo-500/20 text-indigo-300 px-2 py-0.5 rounded-full font-bold">En direct</span>
                                </div>
                                
                                <div class="grid grid-cols-4 gap-2 text-center">
                                    <div class="bg-indigo-950/60 p-2 rounded-lg border border-indigo-800/40">
                                        <span class="text-indigo-400 text-xs block font-bold">32</span>
                                        <span class="text-[9px] text-slate-400">Stagiaires</span>
                                    </div>
                                    <div class="bg-purple-950/60 p-2 rounded-lg border border-purple-800/40">
                                        <span class="text-purple-400 text-xs block font-bold">26</span>
                                        <span class="text-[9px] text-slate-400">En stage</span>
                                    </div>
                                    <div class="bg-amber-950/60 p-2 rounded-lg border border-amber-800/40">
                                        <span class="text-amber-400 text-xs block font-bold">6</span>
                                        <span class="text-[9px] text-slate-400">Finis</span>
                                    </div>
                                    <div class="bg-emerald-950/60 p-2 rounded-lg border border-emerald-800/40">
                                        <span class="text-emerald-400 text-xs block font-bold">12</span>
                                        <span class="text-[9px] text-slate-400">Alertes IA</span>
                                    </div>
                                </div>

                                <div class="bg-slate-900 p-2.5 rounded-xl border border-slate-800 text-[10px] text-slate-300 flex items-center justify-between">
                                    <span>📍 Pointage géolocalisé validé - CMA TYO</span>
                                    <span class="text-emerald-400 font-bold">✔ À l'instant</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dark Curved Block CTA (Matching Mockup Right Curved Section) -->
                    <div class="w-full bg-[#0d1527] border border-slate-800 p-6 sm:p-8 rounded-3xl shadow-2xl relative overflow-hidden flex flex-col sm:flex-row items-center justify-between gap-6">
                        <div class="space-y-1 text-center sm:text-left">
                            <h3 class="text-2xl font-black italic text-white tracking-wide">
                                La technologie <br />
                                au service de <span class="gradient-text">votre réussite !</span>
                            </h3>
                        </div>
                        
                        <a href="{{ route('demande.form') }}" class="gradient-bg-primary text-white font-bold text-sm px-6 py-3.5 rounded-full shadow-lg shadow-indigo-600/40 hover:opacity-95 transition flex items-center gap-2 shrink-0">
                            <span>🚀 Commencer maintenant</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer id="footer" class="bg-white dark:bg-[#060911] border-t border-slate-200 dark:border-slate-800/80 py-8 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-slate-500 dark:text-slate-400">
            
            <!-- Left Copyright -->
            <div class="flex items-center gap-2">
                <span class="font-bold text-slate-800 dark:text-slate-200">© 2026 StageTrack.</span>
                <span>Tous droits réservés.</span>
            </div>

            <!-- Center Keywords -->
            <div class="flex items-center gap-3 font-semibold text-slate-600 dark:text-slate-400">
                <span>IA</span>
                <span>•</span>
                <span>Géolocalisation</span>
                <span>•</span>
                <span>Innovation</span>
                <span>•</span>
                <span>Réussite</span>
            </div>

            <!-- Right Tagline -->
            <div class="flex items-center gap-2 font-bold text-indigo-600 dark:text-indigo-400">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>Ensemble pour un avenir meilleur</span>
            </div>

        </div>
    </footer>

</body>
</html>
