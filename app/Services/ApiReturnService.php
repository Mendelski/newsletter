<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class ApiReturnService
{
    public static function apiReturnError(array $data = [], string $message = 'Error', int $code = 400): JsonResponse
    {
        return self::apiReturnSuccess($data, $message, $code);
    }

    public static function apiReturnSuccess(array $data = [], string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json(['message' => $message, 'data' => $data, 'error' => $code >= 400], $code);
    }
}
