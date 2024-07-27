<?php

use App\Constants\Constants;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

if (!function_exists('responseJson')) {
    function responseJson(string $type, mixed $data = null, string $message = null, int $status = Response::HTTP_OK): JsonResponse
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
            ], Response::HTTP_INTERNAL_SERVER_ERROR)
        };
    }
}

if (!function_exists('exceptionResponseJson')) {
    function exceptionResponseJson(string $message, string $exceptionMessage): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'exceptionMessage' => $exceptionMessage
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
