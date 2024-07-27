<?php

use App\Constants\Constants;
use Illuminate\Http\JsonResponse;

if (!function_exists('responseJson')) {
    function responseJson(string $type, mixed $data = null, string $message = null, int $status = 200): JsonResponse
    {
        return match ($type) {
            'data' => response()->json([
                'data' => $data,
            ], $status),
            'message' => response()->json([
                'message' => $message
            ], $status),
            'dataAndMessage' => response()->json([
                'data' => $data,
                'message' => $message
            ], $status),
            default => response()->json([
                'message' => Constants::GENERAL_EXCEPTION_ERROR_MESSAGE
            ], 500)
        };
    }
}

if (!function_exists('exceptionResponseJson')) {
    function exceptionResponseJson(string $message, string $exceptionMessage): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'exceptionMessage' => $exceptionMessage
        ], 500);
    }
}
