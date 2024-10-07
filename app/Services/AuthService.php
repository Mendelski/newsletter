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
}
