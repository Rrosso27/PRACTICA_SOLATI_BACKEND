<?php

namespace App\Return;

class ReturnFormat
{
    public static function jsonData($success, $message, $data, $status = 200)
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    /**
     * Return success response
     */
    public function success($data = null, $message = 'Success', $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    /**
     * Return error response
     */
    public function error($message = 'Error', $status = 400, $data = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data
        ], $status);
    }
}
