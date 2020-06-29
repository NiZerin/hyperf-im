<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 6/29/2020
 * Time: 11:28 AM
 * FileName: Chat.php
 */


namespace Src\WebSocket\controller;

use Swoole\WebSocket\Frame;

/**
 * 一对一聊天消息
 * Class Chat
 *
 * @package Src\WebSocket\controller
 */
class Chat
{
    /**
     * @param  Frame  $frame
     * @param  \Swoole\WebSocket\Server $server
     * @param $message
     */
    public static function send($frame, $server, object $message)
    {
        $userId = redis()->hGet('im_user_online', (string)$frame->fd);
        $toUserFd = redis()->hGet('user_id_to_fd', (string)$message->to_user_id);

        $toUserMsg = [
            'action' => 'msg_from_user',
            'message' => $message->message,
            'from_user' => [
                'id' => $userId
            ],
            'target_user' => [
                'id' => ''
            ]
        ];

        $server->push($toUserFd, success('new msg', 0, $toUserMsg));
        $server->push($frame->fd, success('msg send seccess'));
    }
}