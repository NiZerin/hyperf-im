<?php


namespace App\Websocket\User;


use App\Websocket\Websocket;

class UserCache extends Websocket
{
    const ONLINE_USER = 'IM_ONLINE_USER';

    public function setUserOnline(int $fd)
    {
        $this->redis->lPush(self::ONLINE_USER, $fd);
    }

    public function setUserOutline(int $fd)
    {
        $this->redis->lRem(self::ONLINE_USER, $fd, 0);
    }
}