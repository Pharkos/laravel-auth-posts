<?php

namespace App\Http\Controllers;

use App\Models\Post;

// Controller a singola azione: gestisce solo la pagina Home
class HomeController extends Controller
{
    public function __invoke()
    {
        // Ultimi 3 post con il loro autore (with('user') evita il problema N+1)
        $latestPosts = Post::with('user')->latest()->take(3)->get();

        return view('home', [
            'pageTitle' => 'Home',
            'metaTitle' => 'Laravel Auth & Posts: pagina iniziale',
            'latestPosts' => $latestPosts,
        ]);
    }
}