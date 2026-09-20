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
    <div class="fixed top-0 left-1/4 w-[400px] h-[400px] bg-indigo-600/10 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="fixed bottom-0 right-1/4 w-[400px] h-[400px] bg-purple-600/10 rounded-full blur-[140px] pointer-events-none"></div>

    <!-- Navigation Header -->
    <header class="sticky top-0 z-50 bg-slate-950/90 backdrop-blur-xl border-b border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-2">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 shrink-0 group">
                <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl sm:rounded-2xl gradient-bg-primary flex items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:scale-105 transition duration-300">
                    <i class="fa-solid fa-graduation-cap text-lg sm:text-2xl text-white"></i>
                </div>
                <span class="font-extrabold text-base sm:text-xl tracking-tight text-white">
                    Suivi<span class="gradient-text">Stagiaires</span>
                </span>
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-300">
                <a href="#fonctionnalites" class="hover:text-indigo-400 transition">Fonctionnalités</a>
                <a href="#processus" class="hover:text-indigo-400 transition">Comment ça marche</a>
            </nav>

            <!-- User Auth / Action Button -->
            <div class="flex items-center gap-2 shrink-0">
                @auth
                    @php
                        $targetRoute = match(auth()->user()->role) {
                            'admin' => route('admin.dashboard'),
                            'encadrant' => route('encadrant.dashboard'),
                            'stagiaire' => route('stagiaire.dashboard'),
                            default => route('login'),
                        };
                    @endphp
                    <a href="{{ $targetRoute }}" class="gradient-bg-primary text-white font-semibold text-xs sm:text-sm px-3.5 py-2 sm:px-5 sm:py-2.5 rounded-xl shadow-lg shadow-indigo-600/25 hover:opacity-90 transition flex items-center gap-1.5 whitespace-nowrap">
                        <i class="fa-solid fa-user"></i>
                        <span>Mon Espace</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-xs sm:text-sm font-semibold text-slate-300 hover:text-white px-3 py-2 sm:px-4 sm:py-2.5 rounded-xl border border-slate-800 hover:bg-slate-900 transition whitespace-nowrap">
                        Se connecter
                    </a>
                    <a href="{{ route('demande.form') }}" class="gradient-bg-primary text-white font-semibold text-xs sm:text-sm px-4 py-2 sm:px-5 sm:py-2.5 rounded-xl shadow-lg shadow-indigo-600/25 hover:opacity-90 transition hidden sm:inline-flex items-center gap-2 whitespace-nowrap">
                        <i class="fa-solid fa-paper-plane"></i> Postuler un Stage
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative pt-12 pb-16 sm:pt-20 sm:pb-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center relative z-10 space-y-6">
            
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-300 text-xs sm:text-sm font-semibold">
                <span class="flex h-2 w-2 rounded-full bg-indigo-400 animate-pulse"></span>
                Plateforme Digitale de Suivi des Stages
            </div>

            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight">
                Pilotez le suivi continu de vos <span class="gradient-text">stagiaires</span> en toute simplicité.
            </h1>

            <p class="text-sm sm:text-base text-slate-400 max-w-xl mx-auto leading-relaxed">
                Candidatures en ligne, présences géolocalisées, objectifs périodiques et délivrance des attestations officielles.
            </p>

            <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3.5 max-w-sm sm:max-w-none mx-auto">
                <a href="{{ route('demande.form') }}" class="w-full sm:w-auto gradient-bg-primary text-white font-bold text-sm px-6 py-3.5 rounded-xl shadow-xl shadow-indigo-600/25 hover:opacity-95 transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> Déposer une Demande de Stage
                </a>
                <a href="{{ route('login') }}" class="w-full sm:w-auto bg-slate-900 hover:bg-slate-800 text-slate-200 border border-slate-700/80 font-semibold text-sm px-6 py-3.5 rounded-xl transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-right-to-bracket"></i> Espace Connexion
                </a>
            </div>

        </div>
    </section>

    <!-- Features Section -->
    <section id="fonctionnalites" class="py-16 bg-slate-900/40 border-y border-slate-800/80">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <h2 class="text-xs font-bold uppercase tracking-widest text-indigo-400 mb-2">Services & Modules</h2>
                <p class="text-xl sm:text-3xl font-extrabold text-white">Tout ce dont vous avez besoin pour vos stages</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Feature 1 -->
                <div class="glass-panel p-6 sm:p-7 rounded-2xl border border-slate-800 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Présences & Géolocalisation</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Pointage journalier sécurisé avec validation géographique sur le lieu de stage.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="glass-panel p-6 sm:p-7 rounded-2xl border border-slate-800 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-500/10 border border-purple-500/20 text-purple-400 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-list-check"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Objectifs & Rapports</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Attribution de la feuille de route et soumission des bilans d'activités périodiques.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="glass-panel p-6 sm:p-7 rounded-2xl border border-slate-800 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Attestations PDF Officielles</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Cartes digitales de stagiaire et génération instantanée d'attestations de fin de stage.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="processus" class="py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <h2 class="text-xs font-bold uppercase tracking-widest text-indigo-400 mb-2">Parcours de stage</h2>
                <p class="text-xl sm:text-3xl font-extrabold text-white">Comment ça marche ?</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="glass-panel p-6 rounded-2xl border border-slate-800 text-center space-y-2.5">
                    <div class="w-9 h-9 rounded-full gradient-bg-primary text-white font-extrabold mx-auto flex items-center justify-center text-xs shadow-md">1</div>
                    <h4 class="font-bold text-base text-white">Candidature</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">Soumission de votre dossier en ligne.</p>
                </div>

                <div class="glass-panel p-6 rounded-2xl border border-slate-800 text-center space-y-2.5">
                    <div class="w-9 h-9 rounded-full gradient-bg-primary text-white font-extrabold mx-auto flex items-center justify-center text-xs shadow-md">2</div>
                    <h4 class="font-bold text-base text-white">Suivi Continu</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">Pointages et rédaction des comptes-rendus.</p>
                </div>

                <div class="glass-panel p-6 rounded-2xl border border-slate-800 text-center space-y-2.5">
                    <div class="w-9 h-9 rounded-full gradient-bg-primary text-white font-extrabold mx-auto flex items-center justify-center text-xs shadow-md">3</div>
                    <h4 class="font-bold text-base text-white">Attestation</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">Validation finale et téléchargement PDF.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-950 border-t border-slate-800/80 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-400">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-lg gradient-bg-primary flex items-center justify-center text-white text-[10px] font-bold">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <span class="font-bold text-slate-200">SuiviStagiaires</span>
                <span>&copy; {{ date('Y') }}</span>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('demande.form') }}" class="hover:text-indigo-400 transition">Demande de stage</a>
                <a href="{{ route('login') }}" class="hover:text-indigo-400 transition">Connexion</a>
                <a href="{{ route('password.request') }}" class="hover:text-indigo-400 transition">Mot de passe oublié</a>
            </div>
        </div>
    </footer>

</body>
</html>
