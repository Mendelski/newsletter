<?php

namespace App\Policies;

use App\Models\Posts;
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

    public function update(User $user, Posts $posts): bool
    {
        return $user->hasRole('admin') || $user->id === $posts->user_id;
    }

    public function delete(User $user, Posts $posts): bool
    {
        return $user->hasRole('admin') || $user->id === $posts->user_id;
    }

    public function restore(User $user, Posts $posts): bool
    {
        return $user->hasRole('admin');
    }
}
