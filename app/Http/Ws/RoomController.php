<?php


namespace App\Http\Ws;



class RoomController extends ImBase
{
    const JOIN_ROOM = 'join_room';
    const SEND_MSG = 'send_msg';
    const ROOM_ONLINE = 'ROOM_ONLINE_USER:';
    const USER_ON_ROOM = 'USER_ON_ROOM';
    const USER_BIND_FD = 'USER_BIND_FD';


    public function checkData($frame, $serve)
    {
        $this->serve = $serve;
        $this->frame = $frame;

        var_dump($frame->data);

        $msgData = json_decode($frame->data);
        if (!$this->verifyData($msgData)){
            return false;
        }

        $optType = $msgData->opt_type;
        if ($optType === self::JOIN_ROOM){
            return $this->joinRoom($msgData);
        }
        if ($optType === self::SEND_MSG){
            return $this->sendMsg($msgData);
        }

        $errorData = ImBase::json('Invalid msg data', ImBase::BUSINESS_NOT_EXIST_CODE);
        $this->serve->push($this->frame->fd, $errorData);
        return false;
    }

    /**
     * @param  object  $msgData
     * @return array
     */
    protected function sendMsg(object $msgData) :void
    {
        $msgData = MessageController::getInstance($this->serve)->formatMsgData($msgData);
        $roomUser = $this->cache->hVals(self::ROOM_ONLINE.$msgData->room_id);
        foreach ($roomUser as $k => $v) {
            if (!$this->serve->isEstablished($v)) {
                // 如果连接不可用则忽略
                continue;
            }
            $this->serve->push($v, json_encode($msgData, 256));
        }
    }

    /**
     * @param  int  $fd
     */
    public function outRoom(int $fd): void
    {
        $fd = (string)$fd;
        $imId = (string)$this->cache->hGet(self::USER_BIND_FD, $fd);
        /*
         * get im user , if im user exist , keep running
         */
        if (!is_bool($imId)) {
            $roomId = $this->cache->hGet(self::USER_ON_ROOM, $imId);
            $this->cache->hDel(self::ROOM_ONLINE.$roomId, $imId);
            $this->cache->hDel(self::USER_ON_ROOM, $imId);
            $this->cache->hDel(self::USER_BIND_FD, $fd);
        }
    }

    /**
     * @param  object  $joinInfo
     * @return void
     */
    protected function joinRoom(object $joinInfo): void
    {
        /*
         * If im user joined room before , just take im user out the room
         */
        $this->outRoom($this->frame->fd);
        /*
         * take im user in room cache
         */
        $this->cache->hSet(self::ROOM_ONLINE.$joinInfo->room_id, $joinInfo->im_id, $this->frame->fd);
        /*
         * bind im user to room id
         */
        $this->cache->hSet(self::USER_ON_ROOM, $joinInfo->im_id, $joinInfo->room_id);
        /*
         * bind websocket fd to im user
         */
        $this->cache->hSet(self::USER_BIND_FD, (string)$this->frame->fd, $joinInfo->im_id);
        /*
         * join successful
         */
        $successData = ImBase::json('Successful connection', ImBase::BUSINESS_SUCCESS_CODE, $joinInfo);
        $this->serve->push($this->frame->fd, $successData);
    }


}