<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 6/12/2020
 * Time: 2:11 PM
 * FileName: helper.php
 */


use Hyperf\Utils\ApplicationContext;

if (!function_exists('container')) {
    /**
     * 容器示例
     * @return \Psr\Container\ContainerInterface
     */
    function container()
    {
        return ApplicationContext::getContainer();
    }
}

if (!function_exists('redis')) {
    /**
     * redis 客户端示例
     * @return mixed|\Redis
     */
    function redis()
    {
        return container()->get(Redis::class);
    }
}

if (!function_exists('success')) {
    /**
     * @param  string  $msg
     * @param  int  $success_code
     * @param  array|null  $data
     *
     * @return string
     */
    function success(string $msg, int $success_code, array $data = null): string
    {
        $succeedData = [
            'msg' => $msg,
            'success_code' => $success_code,
            'data' => $data
        ];

        return json_encode($succeedData,256);
    }
}

if (!function_exists('error')) {
    /**
     * @param  string  $msg
     * @param  int  $error_code
     *
     * @return false|string
     */
    function error(string $msg, int $error_code): string
    {
        $errorData = [
            'msg' => $msg,
            'error_code' => $error_code,
        ];
        return json_encode($errorData, 256);
    }
}

if (!function_exists('json')) {
    /**
     * @param  string  $msg
     * @param  int  $code
     * @param  array|null  $data
     *
     * @return string
     */
    function json(string $msg, int $code, array $data = null): string
    {
        $succeedData = [
            'msg' => $msg,
            'code' => $code,
            'data' => $data
        ];

        return json_encode($succeedData,256);
    }
}