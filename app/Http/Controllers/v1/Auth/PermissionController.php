<?php

namespace App\Http\Controllers\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Services\ApiReturnService;
use App\Services\AuthService;

class PermissionController extends Controller
{
    public function changeRole(RoleRequest $request)
    {
        if (! AuthService::isAdmin($request->user())) {
            return ApiReturnService::apiReturnError([], 'You are not authorized to perform this action');
        }

        $data = AuthService::changeRole($request->input('user_id'), $request->input('roles'));

        return ApiReturnService::apiReturnSuccess($data, "User's roles updated successfully");
    }
}
