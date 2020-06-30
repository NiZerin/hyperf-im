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

use App\Model\FriendChatLogModel;
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
    public static function send($frame, $server, array $message)
    {
        $userId = redis()->hGet('im_user_online', (string)$frame->fd);
        $targetUserFd = redis()->hGet('user_id_to_fd', (string)$message['target_user_id']);

        $msgData = [
            'action' => 'msg_from_user',
            'message' => [
                'msg_time' => timestamp(),
                'msg_id' => uuid(),
                'msg_type' => $message['message']['msg_type'],
                'msg_body' => $message['message']['msg_body'],
            ],
            'from_user' => [
                'id' => $userId
            ],
            'target_user' => [
                'id' => $message['target_user_id']
            ]
        ];

        $server->push($targetUserFd, json_encode($msgData, 256));
        $server->push($frame->fd, json_encode($msgData, 256));

        self::save($msgData);
    }

    /**
     * @param  array  $msgData
     */
    public static function save(array $msgData)
    {
        go(function () use ($msgData) {
            FriendChatLogModel::query()->create([
                'from_uid' => $msgData['from_user']['id'],
                'target_uid' => $msgData['target_user']['id'],
                'msg_id' => $msgData['message']['msg_id'],
                'msg_time' => $msgData['message']['msg_time'],
                'msg_type' => $msgData['message']['msg_type'],
                'msg_body' => json_encode($msgData['message']['msg_body'], 256),
            ]);
        });
    }
}