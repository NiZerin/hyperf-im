<?php


namespace App\Websocket\IM;


class ImTools
{
    public static function error(string $msg, int $status_code) :string
    {
        $errorData = [
            'msg' => $msg,
            'error_code' => $status_code,
        ];
        return json_encode($errorData, 256);
    }

    public static function success(string $msg, int $status_code, array $data = null) :string
    {
        $succeedData = [
            'msg' => $msg,
            'success_code' => $status_code,
            'data' => $data
        ];

        return json_encode($succeedData,256);
    }

    public static function json(string $msg, int $status_code, $data = null) :string
    {
        $succeedData = [
            'msg' => $msg,
            'code' => $status_code,
            'data' => $data
        ];

        return json_encode($succeedData,256);
    }
}