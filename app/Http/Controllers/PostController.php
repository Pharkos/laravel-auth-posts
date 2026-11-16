<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function index()
    {
        // Post più recenti per primi, 9 per pagina
        $posts = Post::latest()->paginate(9);

        return view('posts.index', [
            'pageTitle' => 'Posts',
            'metaTitle' => 'Lista dei post',
            'posts' => $posts
        ]);
    }

    public function create()
    {
        return view('posts.create', [
            'pageTitle' => 'Creazione Post',
            'metaTitle' => 'Pagina di creazione del post',
        ]);
    }

    // Salva un nuovo post: la validazione è già stata fatta da PostRequest
    public function store(PostRequest $request)
    {
        $validatedData = $request->validated();

        Post::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('posts.index')->with('success', 'Post creato con successo');
    }

    public function show(Post $post)
    {
        return view('posts.show', [
            'pageTitle' => 'Show',
            'metaTitle' => 'La mia pagina Show',
            'post' => $post,
        ]);
    }

    public function edit(Post $post)
    {
        Gate::authorize('update', $post);

        return view('posts.edit', [
            'pageTitle' => 'Modifica Post',
            'metaTitle' => 'La mia pagina modifica',
            'post' => $post
        ]);
    }

    // Aggiorna un post: solo l'autore (PostPolicy), dati già validati da PostRequest
    public function update(PostRequest $request, Post $post)
    {
        Gate::authorize('update', $post);

        $post->update($request->validated());

        return redirect()->route('posts.show', $post)->with('success', 'Post aggiornato con successo');
    }

    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        // Elimina il post
        $post->delete();

        // Torna alla lista dei post
        return redirect()
            ->route('posts.index')
            ->with('success', 'Post eliminato con successo');
    }
}