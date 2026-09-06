<!DOCTYPE html>
<html lang="fr" class="dark h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | Suivi Stagiaires</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 flex items-center justify-center p-4 relative overflow-hidden font-sans">

    <!-- Ambient Glowing Spheres -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-purple-600/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10">
        <!-- Logo & Branding Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl gradient-bg-primary shadow-xl shadow-indigo-500/20 mb-4 transform hover:scale-105 transition-transform duration-300">
                <i class="fa-solid fa-graduation-cap text-3xl text-white"></i>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                Suivi<span class="gradient-text">Stagiaires</span>
            </h1>
            <p class="text-sm text-slate-400 mt-1">Espace d'authentification sécurisé</p>
        </div>

        <!-- Glassmorphism Auth Card -->
        <div class="glass-panel rounded-2xl p-6 sm:p-8 shadow-2xl shadow-slate-950/80 border border-slate-800">
            <h2 class="text-xl font-bold text-slate-100 mb-6 flex items-center gap-2">
                <i class="fa-solid fa-lock text-indigo-400"></i> Connexion
            </h2>

            @if($errors->any())
                <div class="mb-6 p-4 bg-rose-500/10 border border-rose-500/30 text-rose-300 rounded-xl text-xs sm:text-sm flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-rose-400 text-base flex-shrink-0"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" autocomplete="off" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                        Matricule ou Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-user text-sm"></i>
                        </div>
                        <input type="text" name="identifier" value="{{ old('identifier') }}"
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-900/80 border border-slate-700/80 rounded-xl text-slate-100 text-sm placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition"
                               placeholder="Ex: ADMIN001 ou email@domaine.cm" required>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                        Mot de passe
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-key text-sm"></i>
                        </div>
                        <input type="password" name="password"
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-900/80 border border-slate-700/80 rounded-xl text-slate-100 text-sm placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition"
                               placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit"
                        class="w-full gradient-bg-primary hover:opacity-95 text-white font-semibold py-3 px-4 rounded-xl shadow-lg shadow-indigo-600/30 hover:shadow-indigo-600/50 active:scale-[0.99] transition duration-200 flex items-center justify-center gap-2 text-sm">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <span>Se connecter</span>
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-slate-800/80 space-y-2 text-center text-xs text-slate-400">
                <p class="flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-shield-halved text-slate-500"></i>
                    Mot de passe oublié ? Contactez votre administrateur.
                </p>
                <p>
                    Pas de compte ? 
                    <a href="{{ route('demande.form') }}" class="text-indigo-400 hover:text-indigo-300 font-semibold underline underline-offset-4 transition">
                        Soumettez une demande de stage
                    </a>
                </p>
            </div>
        </div>

        <p class="text-center text-[11px] text-slate-400 mt-8">
            &copy; {{ date('Y') }} Suivi Stagiaires — Plateforme de Gestion Académique & Professionnelle
        </p>
    </div>

</body>
</html>

