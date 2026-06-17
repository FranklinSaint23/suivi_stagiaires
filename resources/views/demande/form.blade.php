<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande de stage</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-r from-purple-900 to-purple-500 py-10 font-sans">

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-2xl p-8">
    <h1 class="text-2xl font-bold text-purple-900 mb-2 text-center">Demande de stage</h1>
    <p class="text-gray-500 text-sm text-center mb-6">Remplissez le formulaire pour soumettre votre candidature.</p>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 border border-green-300 rounded text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 border border-red-300 rounded text-sm">
            <ul class="list-disc pl-4">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('demande.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom *</label>
                <input type="text" name="nom" value="{{ old('nom') }}" required class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Prénom *</label>
                <input type="text" name="prenom" value="{{ old('prenom') }}" required class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone *</label>
                <input type="text" name="telephone" value="{{ old('telephone') }}" required class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sexe *</label>
                <div class="flex gap-4 mt-1">
                    <label class="flex items-center gap-1 text-sm"><input type="radio" name="sexe" value="M" required> Homme</label>
                    <label class="flex items-center gap-1 text-sm"><input type="radio" name="sexe" value="F"> Femme</label>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Filière *</label>
                <select name="filiere" required class="w-full border rounded px-3 py-2 text-sm">
                    <option value="IDE1">IDE1</option>
                    <option value="IDE2">IDE2</option>
                    <option value="IDE3">IDE3</option>
                    <option value="AS">AS</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lieu de stage souhaité *</label>
                <select name="lieu" required class="w-full border rounded px-3 py-2 text-sm">
                    <option value="Hôpital Régional">Hôpital Régional</option>
                    <option value="Hôpital de District">Hôpital de District</option>
                    <option value="CMA TYO">CMA TYO</option>
                </select>
            </div>
            <div></div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date début *</label>
                <input type="date" name="date_debut" required class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date fin *</label>
                <input type="date" name="date_fin" required class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Photo (JPG/PNG) *</label>
                <input type="file" name="photo" accept="image/jpeg,image/png" required class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">CV (PDF) *</label>
                <input type="file" name="cv" accept=".pdf" required class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lettre de motivation (PDF) *</label>
                <input type="file" name="lettre" accept=".pdf" required class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Certificat de scolarité (PDF) *</label>
                <input type="file" name="certificat" accept=".pdf" required class="w-full border rounded px-3 py-2 text-sm">
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="bg-purple-900 text-white px-6 py-2 rounded font-bold hover:bg-purple-700">
                Soumettre ma demande
            </button>
            <a href="{{ route('login') }}" class="border px-4 py-2 rounded text-sm text-gray-600 hover:bg-gray-50">
                Déjà inscrit ? Se connecter
            </a>
        </div>
    </form>
</div>

</body>
</html>
