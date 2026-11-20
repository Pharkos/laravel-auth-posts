<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    // URL dell'immagine da mostrare: quella caricata, altrimenti un placeholder.
    // Nelle view basta usare $post->image_url (logica in un solo posto)
    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => $this->image
            ? Storage::url($this->image)
            : asset('images/post-placeholder.jpg'));
    }
}
