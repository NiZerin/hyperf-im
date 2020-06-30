<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 6/15/2020
 * Time: 1:59 PM
 * FileName: Message.php
 */


namespace Src\WebSocket\controller;

use Swoole\WebSocket\Frame;

/**
 * 消息处理
 * Class Message
 *
 * @package Src\WebSocket
 */
class Message
{
    /**
     * @param  Frame  $frame
     * @param  \Swoole\WebSocket\Server $server
     * @return void
     */
    public static function switch($frame, $server)
    {
        $message = json_decode($frame->data, true);

        if (is_null($message)) {
            $server->push($frame->fd, error('message content error'));
            return;
        }

        if (!array_key_exists('action', $message)) {
            $server->push($frame->fd, error('message action error'));
            return;
        }

        switch ($message['action']) {
            case ('send_msg_to_user') : {
                Chat::send($frame, $server, $message);
            }
            default : {
                return;
            }
        }
    }
}