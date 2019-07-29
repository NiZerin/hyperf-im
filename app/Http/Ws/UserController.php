<?php


namespace App\Http\Ws;



class UserController extends ImBase
{
    const ONLINE_USER = 'IM_ONLINE_USER';

    public function setUserOnline(int $fd)
    {
//        var_dump('setUserOnline');
        $this->cache->lPush(self::ONLINE_USER, $fd);
    }

    public function setUserOutline(int $fd)
    {
//        var_dump('setUserOutline');
        $this->cache->lRem(self::ONLINE_USER, $fd, 0);
    }
}