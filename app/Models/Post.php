<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
// inserisci i campi per testare il funzionamento
        protected $fillable = [
        'user_id',
        'title',
        'content',
        
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}

}
