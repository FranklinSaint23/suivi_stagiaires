<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
@page { margin: 0; size: 148mm 105mm landscape; }
* { box-sizing: border-box; }
body { margin: 0; padding: 0; font-family: DejaVu Sans, sans-serif; background: #fff; width: 148mm; height: 105mm; }

.header {
    background: #4b0082;
    color: #fff;
    text-align: center;
    padding: 7px 10px;
    font-size: 10pt;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 1.5px;
}

.body-table {
    width: 100%;
    border-collapse: collapse;
    padding: 8px 12px;
}

.photo-cell {
    width: 65px;
    vertical-align: top;
    padding: 8px 10px 6px 12px;
}

.photo-img {
    width: 55px;
    height: 68px;
    object-fit: cover;
    border-radius: 4px;
    border: 1px solid #ccc;
    display: block;
}

.photo-placeholder {
    width: 55px;
    height: 68px;
    background: #e9d5ff;
    border-radius: 4px;
    border: 1px solid #ccc;
    text-align: center;
    color: #4b0082;
    font-size: 22pt;
    font-weight: bold;
    line-height: 68px;
}

.badge {
    background: #4b0082;
    color: #fff;
    font-size: 6.5pt;
    text-align: center;
    padding: 2px 4px;
    border-radius: 3px;
    margin-top: 5px;
    letter-spacing: 0.5px;
}

.info-cell {
    vertical-align: top;
    padding: 8px 12px 6px 0;
}

.name {
    font-size: 11.5pt;
    font-weight: bold;
    color: #4b0082;
    padding-bottom: 4px;
    margin-bottom: 5px;
    border-bottom: 1.5px solid #e9d5ff;
}

.info-row td {
    font-size: 7.8pt;
    color: #333;
    padding: 1.5px 0;
    vertical-align: top;
}

.info-label {
    color: #5b21b6;
    width: 75px;
    font-weight: bold;
    white-space: nowrap;
    padding-right: 6px;
}

.footer {
    background: #f3f0ff;
    border-top: 1px solid #ddd6fe;
    text-align: center;
    padding: 4px;
    font-size: 7pt;
    color: #555;
    position: fixed;
    bottom: 0;
    width: 100%;
}
</style>
</head>
<body>

<div class="header">Carte de Stagiaire</div>

<table class="body-table">
    <tr>
        <td class="photo-cell">
            @if($photoBase64)
                <img class="photo-img" src="{{ $photoBase64 }}" alt="photo">
            @else
                <div class="photo-placeholder">{{ strtoupper(substr($stagiaire->nom, 0, 1)) }}</div>
            @endif
            <div class="badge">STAGIAIRE</div>
        </td>

        <td class="info-cell">
            <div class="name">{{ $stagiaire->prenom }} {{ $stagiaire->nom }}</div>
            <table style="border-collapse:collapse; width:100%;">
                <tr class="info-row">
                    <td class="info-label">Filière :</td>
                    <td>{{ $stagiaire->filiere }}</td>
                </tr>
                <tr class="info-row">
                    <td class="info-label">Sexe :</td>
                    <td>{{ $stagiaire->sexe }}</td>
                </tr>
                <tr class="info-row">
                    <td class="info-label">Né(e) le :</td>
                    <td>{{ $stagiaire->naissance?->format('d/m/Y') }}</td>
                </tr>
                <tr class="info-row">
                    <td class="info-label">Lieu naiss. :</td>
                    <td>{{ $stagiaire->lieu_naissance }}</td>
                </tr>
                <tr class="info-row">
                    <td class="info-label">Téléphone :</td>
                    <td>{{ $stagiaire->telephone }}</td>
                </tr>
                <tr class="info-row">
                    <td class="info-label">Email :</td>
                    <td>{{ $stagiaire->email }}</td>
                </tr>
                <tr class="info-row">
                    <td class="info-label">Lieu stage :</td>
                    <td>{{ $stagiaire->lieu }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<div class="footer">Système de Suivi des Stagiaires &nbsp;·&nbsp; Année {{ date('Y') }}</div>

</body>
</html>
