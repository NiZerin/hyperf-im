<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 6/29/2020
 * Time: 11:28 AM
 * FileName: Group.php
 */


namespace Src\WebSocket\controller;

use App\Model\UserGroupModel;

/**
 * 群聊消息
 * Class Group
 *
 * @package Src\WebSocket\controller
 */
class Group
{
    /**
     * @param \Swoole\WebSocket\Server $server
     * @param  array  $message
     */
    public static function send($server, array $message)
    {
        $userIds = UserGroupModel::query()
            ->select('uid')
            ->where('group_id', $message['target_group_id'])
            ->get();

        $msgData = [
            'action'    => 'msg_from_group',
            'message'   => [
                'msg_time'  => timestamp(),
                'msg_id'    => uuid(),
                'msg_type'  => $message['message']['msg_type'],
                'msg_body'  => $message['message']['msg_body'],
            ],
            'from_user' => [
                'id' => $message['from_user_id']
            ],
            'target_group' => [
                'id' => $message['target_group_id']
            ]
        ];

        foreach ($userIds as $k => $v) {
            $userFd = redis()->hGet('user_id_to_fd', (string)$v->uid);
            if (is_bool($userFd)) {
                continue;
            }
            if ($server->isEstablished((int)$userFd)) {
                $server->push($userFd, json_encode($msgData, 256));
            }
        }
    }
}