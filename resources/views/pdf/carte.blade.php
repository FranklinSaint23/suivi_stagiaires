<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: DejaVu Sans, sans-serif; margin: 0; padding: 10px; }
    .card {
        width: 320px;
        border: 2px solid #4b0082;
        border-radius: 10px;
        overflow: hidden;
        background: #fff;
    }
    .card-header {
        background: #4b0082;
        color: #fff;
        text-align: center;
        padding: 10px;
        font-weight: bold;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .card-body { display: flex; padding: 10px; gap: 10px; }
    .card-photo img { width: 70px; height: 80px; object-fit: cover; border-radius: 4px; border: 1px solid #ccc; }
    .card-photo-placeholder {
        width: 70px; height: 80px; background: #e9d5ff;
        border-radius: 4px; display: flex; align-items: center;
        justify-content: center; color: #4b0082; font-size: 24px; font-weight: bold;
    }
    .card-info { font-size: 10px; line-height: 1.6; color: #333; }
    .card-info p { margin: 0; }
    .card-info .name { font-size: 12px; font-weight: bold; color: #4b0082; }
    .card-footer { background: #f3f0ff; text-align: center; padding: 5px; font-size: 9px; color: #666; }
</style>
</head>
<body>
<div class="card">
    <div class="card-header">Carte de Stagiaire</div>
    <div class="card-body">
        <div class="card-photo">
            @if($stagiaire->photo)
                <img src="{{ storage_path('app/public/' . $stagiaire->photo) }}" alt="photo">
            @else
                <div class="card-photo-placeholder">{{ strtoupper(substr($stagiaire->nom, 0, 1)) }}</div>
            @endif
        </div>
        <div class="card-info">
            <p class="name">{{ $stagiaire->prenom }} {{ $stagiaire->nom }}</p>
            <p>Sexe : {{ $stagiaire->sexe }}</p>
            <p>Né(e) le : {{ $stagiaire->naissance?->format('d/m/Y') }}</p>
            <p>Lieu : {{ $stagiaire->lieu_naissance }}</p>
            <p>Tél : {{ $stagiaire->telephone }}</p>
            <p>Email : {{ $stagiaire->email }}</p>
            <p>Filière : {{ $stagiaire->filiere }}</p>
        </div>
    </div>
    <div class="card-footer">{{ $stagiaire->lieu }} · {{ date('Y') }}</div>
</div>
</body>
</html>
