<?php

namespace Illuminate\framework;

class Request
{
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');

        if ($position === false) {

            return $path;
        }

        return substr($path, 0, $position);
    }

    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isGet()
    {

        return $this->method() === 'get';
    }

    public function isPost()
    {

        return $this->method() === 'post';
    }

    public function getData()
    {
        $body = [];

        if ($this->method() === 'get') {
            $inputData = json_decode(file_get_contents("php://input"), true);

            if ($inputData) {
                foreach ($inputData as $key => $value) {
                    $body[$key] = $value;
                }
            }

            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->method() === 'post') {
            $inputData = json_decode(file_get_contents("php://input"), true);

            if ($inputData) {
                foreach ($inputData as $key => $value) {
                    $body[$key] = $value;
                }
            }

            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }

            foreach ($_FILES as $key => $file) {
                if ($file && $file['error'] !== UPLOAD_ERR_NO_FILE) {
                    $target_dir = './upload/';
                    $body[$key] = $this->uploadFile($file, $target_dir);
                }
            }
        }

        return $body;
    }


    public function uploadFile($file, $target_dir)
    {
        $currentMonth = date("m");
        $currentYear = date("Y");

        $newDir = $target_dir . $currentMonth . '/' . $currentYear . '/';

        if (!file_exists($newDir)) {

            if (!mkdir($newDir, 0777, true)) {

                return false;
            }
        }

        $target_file = $newDir . time() . '_' . basename($file['name']);

        if (move_uploaded_file($file["tmp_name"], $target_file)) {

            return $target_file;
        }

        return $target_file;
    }

    public function getParam()
    {
        $pathInfo = $_SERVER['PATH_INFO'] ?? '/';
        $segments = explode('/', $pathInfo);
        $param = end($segments);
        $param = rtrim($param, '/');

        return $param;
    }

    function getImageExtensionFromBase64($base64String) {
        $data = explode(',', $base64String);
    
        $decodedData = base64_decode($data[1]);
    
        $finfo = finfo_open();
        $mimeType = finfo_buffer($finfo, $decodedData, FILEINFO_MIME_TYPE);
        finfo_close($finfo);
    
        $mimeToExtension = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/bmp' => 'bmp',
        ];

        $extension = $mimeToExtension[$mimeType] ?? null;
    
        return $extension;
    }
}
