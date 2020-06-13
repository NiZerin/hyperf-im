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
    function success(string $msg, int $success_code = 0, array $data = null): string
    {
        return json($msg, $success_code, $data);
    }
}

if (!function_exists('error')) {
    /**
     * @param  string  $msg
     * @param  int  $error_code
     *
     * @param  array|null  $data
     *
     * @return false|string
     */
    function error(string $msg, int $error_code = 1, array $data = null): string
    {
        return json($msg, $error_code, $data);
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
    function json(string $msg, int $code = 0, array $data = null): string
    {
        $succeedData = [
            'msg' => $msg,
            'code' => $code,
            'data' => $data
        ];

        return json_encode($succeedData,256);
    }
}

if (!function_exists('data')) {
    /**
     * @param  string  $msg
     * @param  int  $code
     * @param  array|null  $data
     *
     * @return array
     */
    function data(string $msg, int $code = 0, array $data = null)
    {
        return [
            'msg' => $msg,
            'code' => $code,
            'data' => $data
        ];
    }
}