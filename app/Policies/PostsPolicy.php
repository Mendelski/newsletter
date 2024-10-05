<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostsPolicy
{
    use HandlesAuthorization;

    public function viewAny(): bool
    {
        return true;
    }

    public function view(): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('writer');
    }

    public function update(User $user, Post $post): bool
    {
        return $user->hasRole('admin') || $user->id === $post->user_id;
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->hasRole('admin') || $user->id === $post->user_id;
    }

    public function restore(User $user): bool
    {
        return $user->hasRole('admin');
    }
}
