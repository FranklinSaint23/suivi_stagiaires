<!DOCTYPE html>
<html lang="fr" class="dark h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié | StageTrack</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

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
<body class="min-h-screen bg-slate-50 dark:bg-[#090d16] text-slate-800 dark:text-slate-100 flex items-center justify-center p-4 relative overflow-hidden font-sans transition-colors duration-300">

    <!-- High Quality Unsplash Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=1920&q=80" 
             alt="Support technique" 
             class="w-full h-full object-cover opacity-35 dark:opacity-75 transform hover:scale-105 transition duration-1000">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-100/90 via-slate-100/70 to-slate-100/50 dark:from-black dark:via-black/60 dark:to-black/40 transition-colors duration-300"></div>
    </div>

    <!-- Floating Theme Switcher Button -->
    <div class="fixed top-4 right-4 z-50">
        <button onclick="toggleTheme()" type="button" title="Changer le mode sombre/clair" 
                class="p-2.5 rounded-full text-slate-600 dark:text-slate-300 hover:text-amber-500 dark:hover:text-amber-400 bg-white dark:bg-slate-800/90 border border-slate-200 dark:border-slate-700/80 transition-all duration-200 hover:scale-110 shadow-lg flex items-center justify-center">
            <i class="fa-solid fa-sun text-amber-400 text-base hidden dark:inline"></i>
            <i class="fa-solid fa-moon text-indigo-600 text-base dark:hidden"></i>
        </button>
    </div>

    <!-- Animated Ambient Glowing Orbs -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-indigo-500/10 dark:bg-indigo-600/30 rounded-full blur-[120px] pointer-events-none z-0 animate-pulse-glow"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-purple-500/10 dark:bg-purple-600/30 rounded-full blur-[120px] pointer-events-none z-0 animate-pulse-glow" style="animation-delay: 2.5s;"></div>

    <div class="w-full max-w-md relative z-10 animate-fade-in">
        <!-- Logo & Branding Header -->
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-flex items-center justify-center w-16 h-16 rounded-2xl gradient-bg-primary shadow-xl shadow-indigo-500/30 mb-4 transform hover:scale-110 hover:rotate-3 transition duration-300">
                <i class="fa-solid fa-graduation-cap text-3xl text-white"></i>
            </a>
            <h1 class="text-3xl font-black tracking-tight text-slate-900 dark:text-white flex items-center justify-center gap-1">
                Stage<span class="gradient-text">Track</span>
            </h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 font-medium tracking-wide mt-1 uppercase">Récupération de compte & assistance</p>
        </div>

        <!-- Glassmorphism Recovery Card -->
        <div class="glass-panel backdrop-blur-xl rounded-3xl p-7 sm:p-9 shadow-2xl border border-slate-200 dark:border-slate-700/80 relative overflow-hidden">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2.5">
                    <i class="fa-solid fa-key text-amber-500 dark:text-amber-400"></i> Mot de passe oublié
                </h2>
                <a href="{{ route('login') }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left"></i> Connexion
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-500/15 border border-emerald-500/40 text-emerald-800 dark:text-emerald-200 rounded-2xl text-sm space-y-3">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-600 dark:text-emerald-400 text-xl mt-0.5 shrink-0"></i>
                        <div>
                            <p class="font-bold text-emerald-800 dark:text-emerald-200">Demande enregistrée !</p>
                            <p class="text-xs text-slate-600 dark:text-slate-300 mt-1">{{ session('success') }}</p>
                        </div>
                    </div>

                    @if(session('whatsapp_link'))
                        <div class="pt-2 border-t border-emerald-500/20">
                            <a href="{{ session('whatsapp_link') }}" target="_blank"
                               class="w-full inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold py-2.5 px-4 rounded-xl shadow-md transition">
                                <i class="fa-brands fa-whatsapp text-base"></i> Contacter l'Admin sur WhatsApp
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-rose-500/15 border border-rose-500/40 text-rose-700 dark:text-rose-200 rounded-2xl text-xs sm:text-sm flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 dark:text-rose-400 text-lg shrink-0"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Saisissez votre Email ou Matricule
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-id-card text-sm"></i>
                        </div>
                        <input type="text" name="identifier" value="{{ old('identifier') }}"
                               class="w-full pl-10 pr-4 py-3 bg-white dark:bg-slate-950/80 border border-slate-300 dark:border-slate-700/90 rounded-xl text-slate-900 dark:text-slate-100 text-sm placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 transition"
                               placeholder="Ex: STG20260001 ou email@domaine.cm" required>
                    </div>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1.5 leading-relaxed">
                        Une notification de réinitialisation sera instantanément envoyée à l'administrateur.
                    </p>
                </div>

                <button type="submit"
                        class="w-full gradient-bg-primary hover:opacity-95 text-white font-extrabold py-3.5 px-4 rounded-xl shadow-xl shadow-indigo-600/40 active:scale-[0.98] transition duration-200 flex items-center justify-center gap-2 text-sm">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Envoyer la demande</span>
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-800 text-center text-xs text-slate-500 dark:text-slate-400 space-y-2">
                <p>Vous vous rappelez de votre mot de passe ?</p>
                <a href="{{ route('login') }}" class="inline-block text-indigo-600 dark:text-indigo-400 hover:underline font-bold transition">
                    Retourner à la page de connexion
                </a>
            </div>
        </div>

        <p class="text-center text-[11px] text-slate-500 dark:text-slate-400 mt-8 font-medium">
            &copy; {{ date('Y') }} StageTrack — Support & Récupération
        </p>
    </div>

</body>
</html>

