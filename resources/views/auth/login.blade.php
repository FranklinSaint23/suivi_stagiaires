<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | Suivi Stagiaires</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-r from-purple-900 to-purple-500 flex items-center justify-center font-sans">

    <div class="bg-white rounded-xl shadow-2xl p-8 w-full max-w-md">
        <h2 class="text-2xl font-bold text-purple-900 text-center mb-6">Connexion</h2>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 border border-red-300 rounded text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" autocomplete="off">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Matricule ou Email</label>
                <input type="text" name="identifier" value="{{ old('identifier') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                       placeholder="Entrez votre matricule ou email" required>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                <input type="password" name="password"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                       placeholder="Entrez votre mot de passe" required>
            </div>

            <button type="submit"
                    class="w-full bg-purple-900 hover:bg-purple-700 text-white font-bold py-2 rounded-lg transition">
                Se connecter
            </button>
        </form>

        <p class="text-center text-xs text-gray-500 mt-4">
            Mot de passe oublié ? Contactez l'administrateur pour le réinitialiser.
        </p>
        <p class="text-center text-xs text-gray-500 mt-1">
            Pas de compte ? <a href="{{ route('demande.form') }}" class="text-purple-700 underline">Soumettez une demande de stage</a>.
        </p>
    </div>

</body>
</html>
