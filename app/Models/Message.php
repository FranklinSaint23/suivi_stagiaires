<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'stagiaire_id', 'encadrant_id', 'message', 'expediteur', 'lu',
    ];

    protected function casts(): array
    {
        return ['lu' => 'boolean'];
    }

    public function stagiaire()
    {
        return $this->belongsTo(Stagiaire::class);
    }

    public function encadrant()
    {
        return $this->belongsTo(User::class, 'encadrant_id');
    }

    public function reponses()
    {
        return $this->hasMany(Reponse::class);
    }
}
