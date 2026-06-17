@extends('layouts.app')
@section('title', 'Pointer présence')
@section('sidebar') @include('encadrant.partials.sidebar') @endsection

@section('content')
<h1 class="text-xl font-bold text-purple-900 mb-6">Pointer une présence</h1>

<div class="bg-white rounded-xl shadow p-6 max-w-md">
    <form action="{{ route('encadrant.presences.store') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Stagiaire *</label>
                <select name="stagiaire_id" required class="w-full border rounded px-3 py-2 text-sm">
                    <option value="">-- Choisir --</option>
                    @foreach($stagiaires as $s)
                        <option value="{{ $s->id }}">{{ $s->nom }} {{ $s->prenom }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date *</label>
                <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Présence *</label>
                <div class="flex gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="present" value="1" required class="accent-purple-700">
                        <span class="text-sm text-green-700 font-medium">Présent</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="present" value="0" class="accent-red-500">
                        <span class="text-sm text-red-600 font-medium">Absent</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="mt-6 flex gap-3">
            <button type="submit" class="bg-purple-700 text-white px-5 py-2 rounded hover:bg-purple-800 text-sm">Enregistrer</button>
            <a href="{{ route('encadrant.presences.index') }}" class="border px-4 py-2 rounded text-sm text-gray-600">Voir récap</a>
        </div>
    </form>
</div>
@endsection
