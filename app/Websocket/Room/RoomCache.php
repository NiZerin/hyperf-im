<?php


namespace App\Websocket\Room;


use App\Websocket\Websocket;
use App\Websocket\IM\{ImBase, ImTools};
use Hyperf\HttpMessage\Server\Response;

class RoomCache extends Websocket
{
    const ROOM_ONLINE = 'ROOM_ONLINE_USER:';
    const USER_ON_ROOM = 'USER_ON_ROOM';
    const USER_BIND_FD = 'USER_BIND_FD';
    private static $me = null;

    /**
     * @param  int  $fd
     */
    public function outRoom(int $fd): void
    {
        $fd = (string)$fd;
        /*
         * get im user , if im user exist , keep running
         */
        $imId = (string)$this->redis->hGet(self::USER_BIND_FD, $fd);
        if (!is_bool($imId)) {
            $roomId = $this->redis->hGet(self::USER_ON_ROOM, $imId);
            $this->redis->hDel(self::ROOM_ONLINE.$roomId, $imId);
            $this->redis->hDel(self::USER_ON_ROOM, $imId);
            $this->redis->hDel(self::USER_BIND_FD, $fd);
        }
    }

    /**
     * @param  object  $joinInfo
     * @return void|Response
     */
    public function joinRoom(object $joinInfo): void
    {
        /*
         * If im user joined room before , just take im user out the room
         */
        $this->outRoom($this->frame->fd);
        /*
         * take im user in room redis
         */
        $this->redis->hSet(self::ROOM_ONLINE.$joinInfo->room_id, $joinInfo->im_id, $this->frame->fd);
        /*
         * bind im user to room id
         */
        $this->redis->hSet(self::USER_ON_ROOM, $joinInfo->im_id, $joinInfo->room_id);
        /*
         * bind websocket fd to im user
         */
        $this->redis->hSet(self::USER_BIND_FD, (string)$this->frame->fd, $joinInfo->im_id);
        /*
         * join successful
         */
        $successData = ImTools::json('Successful connection', ImBase::BUSINESS_SUCCESS_CODE, $joinInfo);
        $this->serve->push($this->frame->fd, $successData);
    }

    public static function me()
    {
        if (!(self::$me instanceof RoomCache)) {
            self::$me = new self();
        }
        return self::$me;
    }
}