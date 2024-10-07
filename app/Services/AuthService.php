<?php

namespace App\Services;

use App\Models\User;
use Auth;

class AuthService
{
    public static function login(array $credentials): ?string
    {
        if (! Auth::attempt($credentials)) {
            return null;
        }

        $user = Auth::user();

        return $user->createToken('accessToken')->plainTextToken;
    }

    public static function register($credentials)
    {
        $user = User::create($credentials);

        return $user->createToken('accessToken')->plainTextToken;
    }

    public static function isAdmin(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public static function changeRole(string $userId, array $roles): array
    {
        $user = User::find($userId);
        $user->syncRoles($roles);

        return [
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $roles
        ];
    }
}
