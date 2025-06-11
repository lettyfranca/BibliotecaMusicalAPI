<?php
namespace App\Core;

class Response
{
    public static function json($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public static function success($data = [], $statusCode = 200)
    {
        self::json([
            'status' => 'success',
            'data' => $data
        ], $statusCode);
    }

    public static function error($message, $statusCode = 400)
    {
        self::json([
            'status' => 'error',
            'message' => $message
        ], $statusCode);
    }
}