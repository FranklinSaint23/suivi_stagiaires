<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reponse extends Model
{
    use HasFactory;

    protected $table = 'reponses';

    protected $fillable = ['message_id', 'reponse'];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}
