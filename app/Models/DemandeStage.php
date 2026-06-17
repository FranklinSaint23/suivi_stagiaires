<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DemandeStage extends Model
{
    use HasFactory;

    protected $table = 'demandes_stage';

    protected $fillable = [
        'nom', 'prenom', 'email', 'sexe', 'photo', 'lieu', 'filiere',
        'telephone', 'date_debut', 'date_fin', 'cv', 'lettre', 'certificat',
        'etat', 'mot_de_passe',
    ];

    protected function casts(): array
    {
        return [
            'date_debut' => 'date',
            'date_fin' => 'date',
        ];
    }

    public function scopeEnAttente($query)
    {
        return $query->where('etat', 'En attente');
    }

    public function scopeValidee($query)
    {
        return $query->where('etat', 'Validée');
    }

    public function scopeRefusee($query)
    {
        return $query->where('etat', 'Refusée');
    }
}
