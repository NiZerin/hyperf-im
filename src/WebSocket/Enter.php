<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 6/15/2020
 * Time: 4:06 PM
 * FileName: Enter.php
 */


namespace Src\WebSocket;

use Src\WebSocket\controller\Auth;
use Src\WebSocket\controller\Message;
use Src\WebSocket\controller\User;

/**
 * 统一入口
 * Class Enter
 *
 * @package Src\WebSocket
 */
class Enter
{
    /**
     * @param $frame
     * @param $server
     */
    public static function onMessage($frame, $server): void
    {
        Message::switch($frame, $server);
    }

    /**
     * @param $server
     * @param $fd
     */
    public static function onClose($server, $fd): void
    {
        User::setOutline($server, $fd);
    }

    /**
     * @param $server
     * @param $request
     */
    public static function onOpen($server, $request): void
    {
        Auth::doLogin($server, $request);
    }
}