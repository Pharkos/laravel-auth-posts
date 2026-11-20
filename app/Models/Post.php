<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // inserisci i campi per testare il funzionamento
    // Campi che si possono salvare con create() e update() (mass assignment)
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'image',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
