<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseAPI {

    /**
     * @param string|array $data
     * @param int $code
     * @return JsonResponse
     */
    public static function success($data, int $code = 200, string $message = 'success'): JsonResponse
    {
        return response()->json([
            'data'     => $data,
            'message'  => $message,
            'code'     => $code
        ], $code);
    }
    

    /**
     * @param string|array $mensaje
     * @param int $code
     * @return JsonResponse
     */
    public static function fail($message, int $code = 500): JsonResponse
    {
        return response()->json([
            'data'     => [],
            'message'  => $message,
            'code'     => $code
        ], $code);
    }
}