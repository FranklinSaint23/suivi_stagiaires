<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nom',
        'matricule',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isEncadrant(): bool
    {
        return $this->role === 'encadrant';
    }

    public function isStagiaire(): bool
    {
        return $this->role === 'stagiaire';
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'encadrant_id');
    }
}
