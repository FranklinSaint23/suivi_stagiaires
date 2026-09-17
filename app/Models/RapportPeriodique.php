<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RapportPeriodique extends Model
{
    use HasFactory;

    protected $table = 'rapports_periodiques';

    protected $fillable = [
        'stagiaire_id',
        'stage_id',
        'titre',
        'periode',
        'contenu',
        'fichier',
        'statut',
        'commentaire_encadrant',
        'analyse_ia',
        'date_soumission',
    ];

    protected $casts = [
        'date_soumission' => 'datetime',
    ];

    public function stagiaire()
    {
        return $this->belongsTo(Stagiaire::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
}
