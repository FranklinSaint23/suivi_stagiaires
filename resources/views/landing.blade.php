<!DOCTYPE html>
<html lang="fr" class="dark h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuiviStagiaires — Plateforme de Gestion & Suivi Continu des Stages</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 font-sans antialiased selection:bg-indigo-500 selection:text-white">

    <!-- Ambient Glow Effects -->
    <div class="fixed top-0 left-1/4 w-[500px] h-[500px] bg-indigo-600/15 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="fixed bottom-0 right-1/4 w-[500px] h-[500px] bg-purple-600/15 rounded-full blur-[140px] pointer-events-none"></div>

    <!-- Navigation Header -->
    <header class="sticky top-0 z-50 bg-slate-950/80 backdrop-blur-xl border-b border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-2xl gradient-bg-primary flex items-center justify-center shadow-lg shadow-indigo-500/25 group-hover:scale-105 transition duration-300">
                    <i class="fa-solid fa-graduation-cap text-2xl text-white"></i>
                </div>
                <span class="font-extrabold text-xl tracking-tight text-white">
                    Suivi<span class="gradient-text">Stagiaires</span>
                </span>
            </a>

            <!-- Desktop Links -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-300">
                <a href="#fonctionnalites" class="hover:text-indigo-400 transition">Fonctionnalités</a>
                <a href="#processus" class="hover:text-indigo-400 transition">Comment ça marche</a>
                <a href="#public" class="hover:text-indigo-400 transition">Pour qui ?</a>
            </nav>

            <!-- Actions -->
            <div class="flex items-center gap-3">
                @auth
                    @php
                        $targetRoute = match(auth()->user()->role) {
                            'admin' => route('admin.dashboard'),
                            'encadrant' => route('encadrant.dashboard'),
                            'stagiaire' => route('stagiaire.dashboard'),
                            default => route('login'),
                        };
                    @endphp
                    <a href="{{ $targetRoute }}" class="gradient-bg-primary text-white font-semibold text-xs sm:text-sm px-5 py-2.5 rounded-xl shadow-lg shadow-indigo-600/25 hover:opacity-90 transition flex items-center gap-2">
                        <i class="fa-solid fa-user"></i> Mon Espace ({{ ucfirst(auth()->user()->role) }})
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-xs sm:text-sm font-semibold text-slate-300 hover:text-white px-4 py-2.5 rounded-xl border border-slate-800 hover:bg-slate-900 transition">
                        Se connecter
                    </a>
                    <a href="{{ route('demande.form') }}" class="gradient-bg-primary text-white font-semibold text-xs sm:text-sm px-5 py-2.5 rounded-xl shadow-lg shadow-indigo-600/25 hover:opacity-90 transition hidden sm:inline-flex items-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i> Postuler un Stage
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative pt-16 pb-20 md:pt-24 md:pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-300 text-xs sm:text-sm font-semibold mb-8 backdrop-blur-md">
                <span class="flex h-2 w-2 rounded-full bg-indigo-400 animate-pulse"></span>
                Solution Digitale de Suivi & d'Évaluation des Stagiaires
            </div>

            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-tight max-w-4xl mx-auto">
                Pilotez et valorisez le parcours de vos <span class="gradient-text">stagiaires</span> en toute simplicité.
            </h1>

            <p class="mt-6 text-base sm:text-lg text-slate-400 max-w-2xl mx-auto leading-relaxed">
                De la candidature en ligne jusqu'à la délivrance de l'attestation finale, bénéficiez d'un suivi continu des présences, des objectifs et des comptes-rendus.
            </p>

            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('demande.form') }}" class="w-full sm:w-auto gradient-bg-primary text-white font-bold text-sm sm:text-base px-8 py-4 rounded-2xl shadow-xl shadow-indigo-600/30 hover:opacity-95 transition flex items-center justify-center gap-3">
                    <i class="fa-solid fa-file-pen"></i> Déposer une Demande de Stage
                </a>
                <a href="{{ route('login') }}" class="w-full sm:w-auto bg-slate-900 hover:bg-slate-800 text-slate-200 border border-slate-700/80 font-semibold text-sm sm:text-base px-8 py-4 rounded-2xl transition flex items-center justify-center gap-3">
                    <i class="fa-solid fa-right-to-bracket"></i> Accéder à l'Espace Sécurisé
                </a>
            </div>

            <!-- Key Feature Badges Row -->
            <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto text-left">
                <div class="glass-panel p-4 rounded-2xl border border-slate-800 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-white">Géolocalisation</h4>
                        <p class="text-[11px] text-slate-400">Pointage géographique</p>
                    </div>
                </div>

                <div class="glass-panel p-4 rounded-2xl border border-slate-800 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-500/10 border border-purple-500/20 text-purple-400 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-list-check"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-white">Objectifs & Rapports</h4>
                        <p class="text-[11px] text-slate-400">Suivi continu des livrables</p>
                    </div>
                </div>

                <div class="glass-panel p-4 rounded-2xl border border-slate-800 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-robot"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-white">Analyse Assistée</h4>
                        <p class="text-[11px] text-slate-400">Synthèse automatique</p>
                    </div>
                </div>

                <div class="glass-panel p-4 rounded-2xl border border-slate-800 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-white">Attestations PDF</h4>
                        <p class="text-[11px] text-slate-400">Génération officielle</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Features Section -->
    <section id="fonctionnalites" class="py-20 bg-slate-900/40 border-y border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-xs font-bold uppercase tracking-widest text-indigo-400 mb-2">Un écosystème complet</h2>
                <p class="text-2xl sm:text-4xl font-extrabold text-white">Toutes les fonctionnalités nécessaires à la gestion de vos stages</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="glass-panel p-8 rounded-3xl border border-slate-800 space-y-4 hover:border-indigo-500/40 transition duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-building-user"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white">Candidature en Ligne</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Formulaire de demande de stage dématérialisé avec téléversement du CV, lettre de motivation et certificat de scolarité.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="glass-panel p-8 rounded-3xl border border-slate-800 space-y-4 hover:border-purple-500/40 transition duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-purple-500/10 border border-purple-500/20 text-purple-400 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white">Pointage des Présences</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Suivi journalier avec validation géographique (GPS) pour garantir l'assiduité du stagiaire sur le lieu de son stage.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="glass-panel p-8 rounded-3xl border border-slate-800 space-y-4 hover:border-cyan-500/40 transition duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-file-signature"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white">Rapports & Livrables</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Soumission périodique de comptes-rendus avec pièces jointes et évaluation détaillée par l'encadrant professionnel.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="processus" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-xs font-bold uppercase tracking-widest text-indigo-400 mb-2">Processus fluide</h2>
                <p class="text-2xl sm:text-4xl font-extrabold text-white">Comment se déroule le suivi de votre stage ?</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                <div class="glass-panel p-6 rounded-2xl border border-slate-800 text-center space-y-3">
                    <div class="w-10 h-10 rounded-full gradient-bg-primary text-white font-extrabold mx-auto flex items-center justify-center text-sm shadow-lg">1</div>
                    <h4 class="font-bold text-lg text-white">Soumission de la demande</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">Remplissez vos informations et téléversez vos documents de candidature.</p>
                </div>

                <div class="glass-panel p-6 rounded-2xl border border-slate-800 text-center space-y-3">
                    <div class="w-10 h-10 rounded-full gradient-bg-primary text-white font-extrabold mx-auto flex items-center justify-center text-sm shadow-lg">2</div>
                    <h4 class="font-bold text-lg text-white">Suivi & Validation</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">Effectuez vos pointages et transmettez vos comptes-rendus à votre encadrant.</p>
                </div>

                <div class="glass-panel p-6 rounded-2xl border border-slate-800 text-center space-y-3">
                    <div class="w-10 h-10 rounded-full gradient-bg-primary text-white font-extrabold mx-auto flex items-center justify-center text-sm shadow-lg">3</div>
                    <h4 class="font-bold text-lg text-white">Obtention de l'attestation</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">Téléchargez votre carte de stagiaire et votre attestation de fin de stage officielle.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-950 border-t border-slate-800/80 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6 text-xs text-slate-400">
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
