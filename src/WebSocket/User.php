<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 6/15/2020
 * Time: 1:40 PM
 * FileName: User.php
 */


namespace Src\WebSocket;

/**
 * 用户上下线
 * Class User
 *
 * @package Src\WebSocket
 */
class User
{
    /**
     * @param  object  $user
     * @param  int  $fd
     * @return void
     */
    public static function setOnline(object $user, int $fd): void
    {
        $fd = (string)$fd;

        redis()->hSet('im_user_online', $fd, (string)$user->id);
        redis()->hSet('user_id_to_fd', (string)$user->id, $fd);
    }

    /**
     * @param  int  $fd
     */
    public static function setOutline(int $fd): void
    {
        $fd = (string)$fd;

        $userId = redis()->hGet('im_user_online', $fd);
        redis()->hDel('user_id_to_fd', $userId);
        redis()->hDel('im_user_online', $fd);
    }
}