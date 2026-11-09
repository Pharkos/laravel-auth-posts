<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

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

    public function store(Request $request)
    {
        // 1. Validation
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // 2. Create Post
        Post::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'user_id' => auth()->id(),
        ]);

        // 3. Redirect
        return redirect()->route('post.index');
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

    public function update(Request $request, Post $post)
    {
        
        Gate::authorize('update', $post);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post->update($validatedData);

        return redirect()->route('post.show', $post->id);
    }

    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        // Elimina il post
        $post->delete();

        // Torna alla lista dei post
        return redirect()
            ->route('post.index')
            ->with('success', 'Post eliminato con successo');
    }
}