<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class MutationResponse
{
    public static function success(
        array $data = [],
        string $message,
        int $statusCode = 200,
    ): JsonResponse {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            ...$data
        ], $statusCode);
    }

    public static function error(
        string $message,
        int $statusCode = 400,
    ): JsonResponse {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $statusCode);
    }

    public static function validationError(
        array $fields,
        int $statusCode = 422
    ): JsonResponse {
        return response()->json([
            'status' => 'validation',
            'fields' => $fields,
        ], $statusCode);
    }
}
