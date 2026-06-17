@extends('layouts.app')
@section('title', 'Gestion des utilisateurs')

@section('sidebar')
    <p class="text-xs uppercase text-purple-300 mb-3 px-2">Admin</p>
    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded hover:bg-purple-700 text-sm">📊 Dashboard</a>
    <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded bg-purple-700 text-sm font-semibold">👤 Utilisateurs</a>
@endsection

@section('content')
<h1 class="text-2xl font-bold text-purple-900 mb-6">Gestion des utilisateurs</h1>

{{-- Alerte mot de passe temporaire --}}
@if(session('temp_password'))
<div class="mb-6 bg-yellow-50 border border-yellow-400 rounded-xl p-5">
    <p class="font-bold text-yellow-800 text-base mb-1">Mot de passe réinitialisé</p>
    <p class="text-yellow-700 text-sm mb-3">
        Compte : <strong>{{ session('reset_user') }}</strong>
    </p>
    <div class="flex items-center gap-3 mb-3">
        <span class="text-sm text-gray-600">Nouveau mot de passe temporaire :</span>
        <code id="tempPwd" class="bg-white border border-yellow-300 px-3 py-1 rounded font-mono text-lg font-bold text-purple-900 tracking-widest">
            {{ session('temp_password') }}
        </code>
        <button onclick="copyTempPwd()" class="text-xs bg-purple-100 hover:bg-purple-200 text-purple-800 px-2 py-1 rounded">
            Copier
        </button>
    </div>
    <p class="text-xs text-yellow-600">Ce mot de passe n'est affiché qu'une seule fois. Communiquez-le à l'utilisateur via WhatsApp.</p>
    @if(session('user_phone'))
        @php
            $phone = preg_replace('/\D/', '', session('user_phone'));
            $wa = 'https://wa.me/237' . ltrim($phone, '0') . '?text=' . urlencode('Votre nouveau mot de passe temporaire : ' . session('temp_password') . ' — Connectez-vous sur l\'application Suivi Stagiaires.');
        @endphp
        <a href="{{ $wa }}" target="_blank"
           class="inline-block mt-2 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold px-4 py-2 rounded-lg">
            Envoyer via WhatsApp
        </a>
    @endif
</div>
@endif

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-purple-900 text-white">
            <tr>
                <th class="px-4 py-3 text-left">Matricule</th>
                <th class="px-4 py-3 text-left">Nom</th>
                <th class="px-4 py-3 text-left">Email</th>
                <th class="px-4 py-3 text-left">Rôle</th>
                <th class="px-4 py-3 text-center">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($users as $user)
            <tr class="hover:bg-purple-50">
                <td class="px-4 py-3 font-mono font-semibold text-purple-800">{{ $user->matricule }}</td>
                <td class="px-4 py-3">{{ $user->nom }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $user->email ?? '—' }}</td>
                <td class="px-4 py-3">
                    @php
                        $colors = ['admin' => 'bg-red-100 text-red-700', 'encadrant' => 'bg-blue-100 text-blue-700', 'stagiaire' => 'bg-green-100 text-green-700'];
                    @endphp
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $colors[$user->role] ?? '' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td class="px-4 py-3 text-center">
                    <form action="{{ route('admin.users.reset_password', $user) }}" method="POST"
                          onsubmit="return confirm('Réinitialiser le mot de passe de {{ addslashes($user->nom) }} ?')">
                        @csrf
                        <button type="submit"
                                class="bg-orange-500 hover:bg-orange-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg">
                            Réinitialiser mdp
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-4 py-6 text-center text-gray-400">Aucun utilisateur.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
function copyTempPwd() {
    const pwd = document.getElementById('tempPwd').innerText.trim();
    navigator.clipboard.writeText(pwd).then(() => alert('Mot de passe copié !'));
}
</script>
@endpush
