<?php

namespace App\Http\Controllers\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UserRequest;
use App\Services\ApiReturnService;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function registerUser(RegisterUserRequest $request): JsonResponse
    {
        $token = AuthService::register($request->validated());

        if ($token) {
            return ApiReturnService::apiReturnSuccess(['token' => $token]);
        }

        return ApiReturnService::apiReturnError([], 'Invalid credentials');
    }

    public function login(UserRequest $request)
    {

        $token = AuthService::login($request->validated());

        if ($token) {
            return ApiReturnService::apiReturnSuccess(['token' => $token]);
        }

        return ApiReturnService::apiReturnError([], 'Invalid credentials', 401);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return ApiReturnService::apiReturnSuccess([], '', 204);
    }
}
