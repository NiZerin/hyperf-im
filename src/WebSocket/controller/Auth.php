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


namespace Src\WebSocket\controller;

/**
 * Class Auth
 *
 * @package Src\WebSocket
 */
class Auth
{
    /**
     * im 登录上线
     * @param  \Swoole\WebSocket\Server  $server
     * @param  \Swoole\Http\Request  $request
     */
    public static function doLogin($server, $request): void
    {
        /** @var $check \stdClass | bool */
        $check = self::checkToken($request->get ?? []);

        if (is_bool($check)) {
            $server->push($request->fd, error('token check failed'));
            $server->close($request->fd);
        } else {
            self::checkOnline($server, $check->id);
            User::setOnline($check, $request->fd);
            $server->push($request->fd, success('login success'));
        }
    }

    /**
     * 单点登录
     *
     * @param  \Swoole\WebSocket\Server  $server
     * @param $userId
     */
    public static function checkOnline($server, $userId): void
    {
        $afterFd = (int)redis()->hGet('user_id_to_fd', (string)$userId);

        if (is_bool($afterFd)) {
            return;
        }

        if ($server->isEstablished($afterFd)) {
            $server->push($afterFd, error('you account login other location'));
            User::setOutline($server, $afterFd);
        }
    }

    /**
     * 校验token
     * @param  array  $data
     *
     * @return false|\Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Builder[]|\Hyperf\Database\Model\Collection|\Hyperf\Database\Model\Model
     */
    public static function checkToken(array $data)
    {
        if (!array_key_exists('token', $data)) {
            return false;
        }

        if (empty($data['token'])) {
            return false;
        }

        return (new \Src\Home\service\Auth())->checkToken($data['token']);
    }
}