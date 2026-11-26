<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        // with('user'): carica gli autori con UNA query sola (evita il problema N+1)
        $posts = Post::with('user')->latest()->paginate(9);

        return view('posts.index', [
            'pageTitle' => 'Post',
            'metaDescription' => 'Lista dei post',
            'posts' => $posts,
        ]);
    }

    public function create()
    {
        return view('posts.create', [
            'pageTitle' => 'Nuovo post',
            'metaDescription' => 'Pagina di creazione del post',
        ]);
    }

    // Salva un nuovo post: la validazione è già stata fatta da PostRequest
    public function store(PostRequest $request)
    {
        $validatedData = $request->validated();

        // Se è stata caricata un'immagine, la salviamo nel disco 'public'
        // (storage/app/public/posts) e nel database teniamo solo il percorso
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        Post::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'image' => $imagePath,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('posts.index')->with('success', 'Post creato con successo');
    }

    public function show(Post $post)
    {
        return view('posts.show', [
            // Nella scheda del browser compare il titolo del post
            'pageTitle' => $post->title,
            // Le prime 150 lettere del contenuto come descrizione per i motori di ricerca
            'metaDescription' => Str::limit($post->content, 150),
            'post' => $post,
        ]);
    }

    public function edit(Post $post)
    {
        Gate::authorize('update', $post);

        return view('posts.edit', [
            'pageTitle' => 'Modifica post',
            'metaDescription' => 'Modifica del post',
            'post' => $post,
        ]);
    }

    // Aggiorna un post: solo l'autore (PostPolicy), dati già validati da PostRequest
    public function update(PostRequest $request, Post $post)
    {
        Gate::authorize('update', $post);

        // Dati validati SENZA l'immagine: se l'utente non sceglie un nuovo file,
        // la colonna 'image' non viene toccata e la vecchia immagine resta
        $data = $request->safe()->except('image');

        if ($request->hasFile('image')) {
            // Prima salviamo la nuova immagine...
            $data['image'] = $request->file('image')->store('posts', 'public');

            // ...poi cancelliamo la vecchia dal disco, per non lasciare file orfani
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
        }

        $post->update($data);

        return redirect()->route('posts.show', $post)->with('success', 'Post aggiornato con successo');
    }

    // Elimina un post: solo l'autore (PostPolicy)
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        // Salviamo il percorso prima di eliminare il post
        $imagePath = $post->image;

        // Prima eliminiamo il post dal database...
        $post->delete();

        // ...poi il file dal disco, per non lasciare file orfani
        if ($imagePath) {
            Storage::disk('public')->delete($imagePath);
        }

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post eliminato con successo');
    }
}