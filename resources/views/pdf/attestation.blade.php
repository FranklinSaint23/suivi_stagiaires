<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: DejaVu Sans, sans-serif; padding: 40px; color: #1a1a1a; }
    .header { text-align: center; margin-bottom: 40px; }
    .title { font-size: 22px; font-weight: bold; text-transform: uppercase; color: #4b0082; margin: 20px 0; }
    .content { font-size: 14px; line-height: 2; text-align: justify; }
    .signature { margin-top: 60px; text-align: right; }
    .border-box { border: 2px solid #4b0082; padding: 30px; border-radius: 8px; }
    hr { border: 1px solid #4b0082; margin: 20px 0; }
</style>
</head>
<body>
<div class="border-box">
    <div class="header">
        <p style="font-size:12px; color:#666;">CENTRE MÉDICAL D'ARRONDISSEMENT</p>
        <div class="title">Attestation de Fin de Stage</div>
        <hr>
    </div>

    <div class="content">
        <p>Nous soussignés, certifions que :</p>
        <br>
        <p><strong>{{ $stagiaire->prenom }} {{ $stagiaire->nom }}</strong>,
        de la filière <strong>{{ $stagiaire->filiere }}</strong>,
        a effectué son stage pratique au sein de :
        <strong>{{ $stagiaire->lieu }}</strong>.</p>
        <br>
        <p>Ce stage s'est déroulé dans de bonnes conditions et le/la stagiaire a fait preuve
        de sérieux, de ponctualité et d'engagement tout au long de sa formation pratique.</p>
        <br>
        <p>La présente attestation lui est délivrée pour servir et valoir ce que de droit.</p>
    </div>

    <div class="signature">
        <p>Fait à {{ $stagiaire->lieu ?? '____' }}, le {{ \Carbon\Carbon::now()->locale('fr')->isoFormat('D MMMM YYYY') }}</p>
        <br><br><br>
        <p style="font-weight:bold;">L'Encadrant</p>
        <p style="font-size:12px; color:#666;">Signature et cachet</p>
    </div>
</div>
</body>
</html>
