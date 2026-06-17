<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Presence extends Model
{
    use HasFactory;

    protected $fillable = [
        'stagiaire_id', 'date', 'present', 'statut',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'present' => 'boolean',
        ];
    }

    public function stagiaire()
    {
        return $this->belongsTo(Stagiaire::class);
    }
}
