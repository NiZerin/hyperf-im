<?php
declare(strict_types=1);

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 6/12/2020
 * Time: 1:51 PM
 * FileName: Auth.php
 */


namespace Src\WebSocket;

/**
 * Class Auth
 *
 * @package Src\WebSocket
 */
class Auth
{

    /**
     * @param  array  $auth
     */
    public static function checkAuth(array $auth)
    {

    }

    /**
     * @param  array  $auth
     *
     * @return false
     */
    public static function doLogin(array $auth)
    {
        if (!array_key_exists('_token', $auth)) {
            return false;
        }
    }

    /**
     *
     */
    public static function checkToken()
    {

    }
}