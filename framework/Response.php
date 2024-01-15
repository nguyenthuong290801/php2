<?php

namespace Illuminate\framework;

class Response
{
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    public static function redirect($url)
    {
        header("Location: " . $url);
        exit;
    }

    public static function json(array $data, int $statusCode = null){
        http_response_code($statusCode);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public static function redirectCurrentPage() {
        $url = $_SERVER['REQUEST_URI'];
        header("Location: " . $url);
        exit;
    }
}
