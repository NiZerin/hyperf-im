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
     * @param  array  $token
     *
     * @return false|\Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Builder[]|\Hyperf\Database\Model\Collection|\Hyperf\Database\Model\Model
     */
    public static function checkToken(array $token)
    {
        if (!array_key_exists('token', $token)) {
            return false;
        }

        return (new \Src\Home\service\Auth())->checkToken($token['token']);
    }
}