<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\Stagiaire;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function attestation(Stagiaire $stagiaire)
    {
        $pdf = Pdf::loadView('pdf.attestation', compact('stagiaire'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("attestation_{$stagiaire->nom}.pdf");
    }

    public function carte(Stagiaire $stagiaire)
    {
        $photoBase64 = null;
        if ($stagiaire->photo) {
            $cleanPath = ltrim(str_replace('storage/', '', $stagiaire->photo), '/');
            $possiblePaths = [
                storage_path('app/public/' . $cleanPath),
                public_path('storage/' . $cleanPath),
                public_path($cleanPath),
                storage_path('app/' . $cleanPath),
            ];

            foreach ($possiblePaths as $fullPath) {
                if (file_exists($fullPath) && is_file($fullPath)) {
                    $content     = file_get_contents($fullPath);
                    $ext         = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
                    $mime        = match($ext) { 'png' => 'image/png', 'gif' => 'image/gif', default => 'image/jpeg' };
                    $photoBase64 = 'data:' . $mime . ';base64,' . base64_encode($content);
                    break;
                }
            }
        }

        $pdf = Pdf::loadView('pdf.carte', compact('stagiaire', 'photoBase64'))
            ->setPaper('a6', 'landscape');

        return $pdf->download("carte_{$stagiaire->nom}.pdf");
    }

    public function presences(Request $request)
    {
        $mois  = $request->integer('mois', now()->month);
        $annee = $request->integer('annee', now()->year);

        $stagiaires = Stagiaire::orderBy('nom')->get();
        $nbJours    = \Carbon\Carbon::createFromDate($annee, $mois, 1)->daysInMonth;

        $presencesMap = [];
        foreach ($stagiaires as $s) {
            $rows = Presence::where('stagiaire_id', $s->id)
                ->whereMonth('date', $mois)
                ->whereYear('date', $annee)
                ->get()
                ->keyBy(fn($p) => $p->date->format('d'));
            $presencesMap[$s->id] = $rows;
        }

        $moisNom = \Carbon\Carbon::createFromDate($annee, $mois, 1)
            ->locale('fr')->isoFormat('MMMM YYYY');

        $pdf = Pdf::loadView('pdf.presences', compact(
            'stagiaires', 'presencesMap', 'nbJours', 'mois', 'annee', 'moisNom'
        ))->setPaper('a4', 'landscape');

        return $pdf->download("presences_{$mois}_{$annee}.pdf");
    }

    public function choixAttestation()
    {
        $stagiaires = Stagiaire::orderBy('nom')->get();
        return view('encadrant.pdf.choix_attestation', compact('stagiaires'));
    }

    public function choixCarte()
    {
        $stagiaires = Stagiaire::orderBy('nom')->get();
        return view('encadrant.pdf.choix_carte', compact('stagiaires'));
    }
}
