<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stage extends Model
{
    use HasFactory;

    protected $fillable = [
        'stagiaire_id', 'date_debut', 'date_fin',
        'etablissement', 'theme', 'rapport', 'convention',
    ];

    protected function casts(): array
    {
        return [
            'date_debut' => 'date',
            'date_fin' => 'date',
        ];
    }

    public function stagiaire()
    {
        return $this->belongsTo(Stagiaire::class);
    }
}
