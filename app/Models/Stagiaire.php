<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Stagiaire extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'sexe', 'nom', 'prenom', 'naissance', 'lieu_naissance',
        'telephone', 'email', 'password', 'photo', 'lieu', 'filiere',
        'latitude', 'longitude',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'naissance' => 'date',
        ];
    }

    public function stages()
    {
        return $this->hasMany(Stage::class);
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function objectifs()
    {
        return $this->hasMany(Objectif::class);
    }

    public function rapports()
    {
        return $this->hasMany(RapportPeriodique::class);
    }

    public function getNomCompletAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    public function getTauxPresenceAttribute(): float
    {
        $total = $this->presences()->count();
        if ($total === 0) return 0;
        $presents = $this->presences()->where('present', true)->count();
        return round(($presents / $total) * 100, 1);
    }

    public function getProgressionGlobaleAttribute(): float
    {
        // 1. Presence (35%)
        $scorePresence = ($this->taux_presence / 100) * 35;

        // 2. Objectifs (35%)
        $totalObj = $this->objectifs()->count();
        $scoreObj = 0;
        if ($totalObj > 0) {
            $doneObj = $this->objectifs()->where('statut', 'Terminé')->count();
            $scoreObj = ($doneObj / $totalObj) * 35;
        }

        // 3. Rapports Periodiques (30%)
        $totalRapports = $this->rapports()->count();
        $scoreRapports = 0;
        if ($totalRapports > 0) {
            $validesRapports = $this->rapports()->where('statut', 'Validé')->count();
            $scoreRapports = ($validesRapports / $totalRapports) * 30;
        }

        // Return rounded global percentage
        return round($scorePresence + $scoreObj + $scoreRapports, 1);
    }
}
