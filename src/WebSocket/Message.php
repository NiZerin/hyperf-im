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


namespace Src\WebSocket;

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
        $message = json_decode($frame->data);

        if (is_null($message)) {
            $server->push($frame->fd, error('message content error'));
            return;
        }

        if (!property_exists($message, 'action')) {
            $server->push($frame->fd, error('message action error'));
            return;
        }

        if ($message->action == 'send_msg_to_user') {
            self::chat($frame, $server, $message);
        }
    }

    /**
     * @param  Frame  $frame
     * @param  \Swoole\WebSocket\Server $server
     * @param $message
     */
    public static function chat($frame, $server, object $message)
    {
        $userId = redis()->hGet('im_user_online', (string)$frame->fd);
        $toUserFd = redis()->hGet('user_id_to_fd', (string)$message->to_user_id);

        $toUserMsg = [
            'action' => 'msg_from_user',
            'message' => $message->message,
            'from_user_id' => $userId
        ];

        $server->push($toUserFd, success('new msg', 0, $toUserMsg));
        $server->push($frame->fd, success('msg send seccess'));
    }
}