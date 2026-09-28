<!DOCTYPE html>
<html lang="fr" class="dark min-h-screen">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande de Stage | StageTrack</title>
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
<body class="min-h-screen bg-slate-50 dark:bg-[#090d16] text-slate-800 dark:text-slate-100 py-10 px-4 font-sans relative overflow-x-hidden transition-colors duration-300">

    <!-- High Quality Unsplash Background Image -->
    <div class="fixed inset-0 z-0 pointer-events-none">
        <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=1920&q=80" 
             alt="Stagiaires en formation" 
             class="w-full h-full object-cover opacity-35 dark:opacity-75 transition-opacity duration-300">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-100/80 via-slate-100/60 to-slate-100/85 dark:from-black/85 dark:via-black/70 dark:to-black/90 transition-colors duration-300"></div>
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
    <div class="fixed -top-40 -left-40 w-96 h-96 bg-indigo-500/10 dark:bg-indigo-600/25 rounded-full blur-[130px] pointer-events-none z-0 animate-pulse-glow"></div>
    <div class="fixed -bottom-40 -right-40 w-96 h-96 bg-purple-500/10 dark:bg-purple-600/25 rounded-full blur-[130px] pointer-events-none z-0 animate-pulse-glow" style="animation-delay: 3s;"></div>

    <div class="max-w-3xl mx-auto relative z-10 animate-fade-in">
        <!-- Header -->
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-flex items-center justify-center w-16 h-16 rounded-2xl gradient-bg-primary shadow-xl shadow-indigo-500/30 mb-4 transform hover:scale-110 hover:rotate-3 transition duration-300">
                <i class="fa-solid fa-file-pen text-3xl text-white"></i>
            </a>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900 dark:text-white flex items-center justify-center gap-2">
                Demande de <span class="gradient-text">Stage</span>
            </h1>
            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1 font-medium">Remplissez le formulaire ci-dessous pour soumettre votre candidature académique</p>
        </div>

        <!-- Glassmorphism Form Card -->
        <div class="bg-white/90 dark:bg-slate-900/85 backdrop-blur-xl rounded-3xl p-6 sm:p-9 border border-slate-200 dark:border-slate-700/80 shadow-2xl space-y-6">
            @if(session('success'))
                <div class="p-4 bg-emerald-500/15 border border-emerald-500/40 text-emerald-700 dark:text-emerald-300 rounded-2xl text-sm flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-xl shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 bg-rose-500/15 border border-rose-500/40 text-rose-700 dark:text-rose-200 rounded-2xl text-xs sm:text-sm">
                    <div class="flex items-center gap-2 font-bold mb-1">
                        <i class="fa-solid fa-triangle-exclamation text-rose-500 dark:text-rose-400"></i> Veuillez corriger les erreurs :
                    </div>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('demande.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Nom *</label>
                        <input type="text" name="nom" value="{{ old('nom') }}" required 
                               class="w-full bg-white dark:bg-slate-950/80 border border-slate-300 dark:border-slate-700/80 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" placeholder="Votre nom">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Prénom *</label>
                        <input type="text" name="prenom" value="{{ old('prenom') }}" required 
                               class="w-full bg-white dark:bg-slate-950/80 border border-slate-300 dark:border-slate-700/80 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" placeholder="Votre prénom">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required 
                               class="w-full bg-white dark:bg-slate-950/80 border border-slate-300 dark:border-slate-700/80 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" placeholder="exemple@domaine.cm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Téléphone *</label>
                        <input type="text" name="telephone" value="{{ old('telephone') }}" required 
                               class="w-full bg-white dark:bg-slate-950/80 border border-slate-300 dark:border-slate-700/80 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" placeholder="Ex: 699000000">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Sexe *</label>
                        <div class="flex items-center gap-6 pt-1">
                            <label class="flex items-center gap-2 cursor-pointer text-sm text-slate-800 dark:text-slate-200">
                                <input type="radio" name="sexe" value="M" required class="accent-indigo-500"> Homme
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer text-sm text-slate-800 dark:text-slate-200">
                                <input type="radio" name="sexe" value="F" class="accent-indigo-500"> Femme
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Filière *</label>
                        <select name="filiere" required class="w-full bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700/80 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:border-indigo-500">
                            <option value="ID1" class="bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100">ID1</option>
                            <option value="ID2" class="bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100">ID2</option>
                            <option value="ID3" class="bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100">ID3</option>
                            <option value="AS" class="bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100">AS</option>
                            <option value="IDE1" class="bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100">IDE1</option>
                            <option value="IDE2" class="bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100">IDE2</option>
                            <option value="IDE3" class="bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100">IDE3</option>
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Lieu de stage souhaité *</label>
                        <select name="lieu" required class="w-full bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700/80 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:border-indigo-500">
                            <option value="Hôpital Régional" class="bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100">Hôpital Régional</option>
                            <option value="Hôpital de District" class="bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100">Hôpital de District</option>
                            <option value="CMA TYO" class="bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100">CMA TYO</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Date début *</label>
                        <input type="date" name="date_debut" required class="w-full bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700/80 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Date fin *</label>
                        <input type="date" name="date_fin" required class="w-full bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700/80 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:border-indigo-500">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Photo d'identité (JPG/PNG) *</label>
                        <input type="file" name="photo" accept="image/jpeg,image/png" required 
                               class="w-full bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700/80 rounded-xl p-2 text-xs text-slate-700 dark:text-slate-300 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">CV (PDF) *</label>
                        <input type="file" name="cv" accept=".pdf" required 
                               class="w-full bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700/80 rounded-xl p-2 text-xs text-slate-700 dark:text-slate-300 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Lettre de motivation (PDF) *</label>
                        <input type="file" name="lettre" accept=".pdf" required 
                               class="w-full bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700/80 rounded-xl p-2 text-xs text-slate-700 dark:text-slate-300 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Certificat de scolarité (PDF) *</label>
                        <input type="file" name="certificat" accept=".pdf" required 
                               class="w-full bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700/80 rounded-xl p-2 text-xs text-slate-700 dark:text-slate-300 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500">
                    </div>
                </div>

                <div class="pt-4 flex flex-col sm:flex-row items-center gap-3">
                    <button type="submit" class="w-full sm:flex-1 gradient-bg-primary hover:opacity-95 text-white font-extrabold py-3.5 px-5 rounded-xl shadow-xl shadow-indigo-600/30 transition text-sm flex items-center justify-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Soumettre ma demande</span>
                    </button>
                    <a href="{{ route('login') }}" class="w-full sm:w-auto bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-300 border border-slate-300 dark:border-slate-700 px-5 py-3.5 rounded-xl text-xs font-bold text-center transition">
                        Se connecter
                    </a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
