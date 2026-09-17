<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objectif extends Model
{
    use HasFactory;

    protected $fillable = [
        'stagiaire_id',
        'stage_id',
        'titre',
        'description',
        'date_limite',
        'statut',
    ];

    protected $casts = [
        'date_limite' => 'date',
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
