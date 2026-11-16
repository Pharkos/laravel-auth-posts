<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    // Solo l'autore del post può modificarlo
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    // Solo l'autore del post può eliminarlo
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }
}
