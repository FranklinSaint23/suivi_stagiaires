<!DOCTYPE html>
<html lang="fr" class="dark h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | StageTrack</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-black text-slate-100 flex items-center justify-center p-4 relative overflow-hidden font-sans">

    <!-- High Quality Unsplash Background Image with Dark Tint -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=1920&q=80" 
             alt="Espace de travail moderne" 
             class="w-full h-full object-cover scale-105 filter blur-sm opacity-35 transform hover:scale-100 transition duration-1000">
        <div class="absolute inset-0 bg-gradient-to-br from-black/95 via-slate-950/90 to-indigo-950/85"></div>
    </div>

    <!-- Animated Ambient Glowing Orbs -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-indigo-600/30 rounded-full blur-[120px] pointer-events-none z-0 animate-pulse-glow"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-purple-600/30 rounded-full blur-[120px] pointer-events-none z-0 animate-pulse-glow" style="animation-delay: 2.5s;"></div>

    <div class="w-full max-w-md relative z-10 animate-fade-in">
        
        <!-- Logo & Branding Header -->
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-flex items-center justify-center w-16 h-16 rounded-2xl gradient-bg-primary shadow-xl shadow-indigo-500/30 mb-4 transform hover:scale-110 hover:rotate-3 transition-all duration-300">
                <i class="fa-solid fa-graduation-cap text-3xl text-white"></i>
            </a>
            <h1 class="text-3xl font-black tracking-tight text-white flex items-center justify-center gap-1">
                Stage<span class="gradient-text">Track</span>
            </h1>
            <p class="text-xs text-slate-400 font-medium tracking-wide mt-1 uppercase">Espace d'authentification sécurisé</p>
        </div>

        <!-- Glassmorphism Auth Card -->
        <div class="backdrop-blur-xl bg-slate-900/80 rounded-3xl p-7 sm:p-9 shadow-2xl border border-slate-700/80 relative overflow-hidden group">
            <div class="absolute -top-24 -right-24 w-48 h-48 bg-indigo-500/10 rounded-full blur-2xl group-hover:bg-indigo-500/20 transition duration-500"></div>

            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2.5">
                    <i class="fa-solid fa-lock text-indigo-400"></i> Connexion
                </h2>
                <a href="{{ url('/') }}" class="text-xs text-slate-400 hover:text-indigo-300 transition flex items-center gap-1 font-semibold">
                    <i class="fa-solid fa-house"></i> Accueil
                </a>
            </div>

            @if($errors->any())
                <div class="mb-6 p-4 bg-rose-500/15 border border-rose-500/40 text-rose-200 rounded-2xl text-xs sm:text-sm flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-rose-400 text-lg shrink-0"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" autocomplete="off" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                        Matricule ou Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-user text-sm"></i>
                        </div>
                        <input type="text" name="identifier" value="{{ old('identifier') }}"
                               class="w-full pl-10 pr-4 py-3 bg-slate-950/80 border border-slate-700/90 rounded-xl text-slate-100 text-sm placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 transition shadow-inner"
                               placeholder="Ex: ADMIN001 ou email@domaine.cm" required>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                        Mot de passe
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-key text-sm"></i>
                        </div>
                        <input type="password" id="passwordInput" name="password"
                               class="w-full pl-10 pr-10 py-3 bg-slate-950/80 border border-slate-700/90 rounded-xl text-slate-100 text-sm placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 transition shadow-inner"
                               placeholder="••••••••" required>
                        <button type="button" onclick="togglePasswordVisibility('passwordInput', this)"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-200 transition focus:outline-none"
                                title="Afficher / Masquer le mot de passe">
                            <i class="fa-solid fa-eye text-sm" id="pwdEyeIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit"
                        class="w-full gradient-bg-primary hover:opacity-95 text-white font-extrabold py-3.5 px-4 rounded-xl shadow-xl shadow-indigo-600/40 active:scale-[0.98] transition duration-200 flex items-center justify-center gap-2 text-sm">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <span>Se connecter</span>
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-slate-800 space-y-2.5 text-center text-xs text-slate-400">
                <p class="flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-shield-halved text-indigo-400"></i>
                    <a href="{{ route('password.request') }}" class="text-indigo-400 hover:text-indigo-300 font-semibold underline underline-offset-4 transition">
                        Mot de passe oublié ?
                    </a>
                </p>
                <p>
                    Pas encore de compte ? 
                    <a href="{{ route('demande.form') }}" class="text-indigo-400 hover:text-indigo-300 font-bold underline underline-offset-4 transition">
                        Soumettre une demande de stage
                    </a>
                </p>
            </div>
        </div>

        <p class="text-center text-[11px] text-slate-500 mt-8 font-medium">
            &copy; {{ date('Y') }} StageTrack — Plateforme de Gestion Académique & Professionnelle
        </p>
    </div>

    <script>
    function togglePasswordVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash', 'text-indigo-400');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash', 'text-indigo-400');
            icon.classList.add('fa-eye');
        }
    }
    </script>
</body>
</html>
