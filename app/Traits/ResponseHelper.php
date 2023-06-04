<?php

namespace App\Traits;

trait ResponseHelper
{

    protected function success($data = [], $message, $code = 200)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function error($message, $code)
    {
        return response()->json([
            'message' => $message
        ], $code);
    }
}
