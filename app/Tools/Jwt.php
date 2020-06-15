<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 6/15/2020
 * Time: 10:56 AM
 * FileName: Jwt.php
 */


namespace App\Tools;

use \Firebase\JWT\JWT as Builder;

/**
 * jwt 工具类
 * Class Jwt
 *
 * @package App\Tools
 */
class Jwt
{
    /**
     * jwt 加密
     *
     * @param  array  $data
     *
     * @return string
     */
    public static function encode(array $data): string
    {
        return Builder::encode($data, 'hyperf-im');
    }

    /**
     * jwt 解密
     *
     * @param  string  $token
     *
     * @return object
     */
    public static function decode(string $token): object
    {
        return Builder::decode($token, 'hyperf-im', ['HS256']);
    }
}