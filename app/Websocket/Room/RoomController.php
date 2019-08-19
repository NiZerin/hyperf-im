<?php


namespace App\Websocket\Room;



use App\Controller\Messages\MessagesController;
use App\Websocket\IM\ImBase;
use App\Websocket\IM\ImTools;
use App\Websocket\IM\ImVerify;
use App\Websocket\Websocket;

class RoomController extends Websocket
{
    const JOIN_ROOM = 'join_room';
    const SEND_MSG = 'send_msg';
    private static $me = null;

    public function checkData(object $msgData)
    {
        var_dump($this->frame->data);
//        $msgData = json_decode($this->frame->data);
        if (!ImVerify::me()->verifyData($msgData)) {
            return false;
        }
        $optType = $msgData->opt_type;
        if ($optType === self::JOIN_ROOM) {
            return RoomCache::me()->joinRoom($msgData);
        }
        if ($optType === self::SEND_MSG) {
            return $this->sendMsg($msgData);
        }

        $errorData = ImTools::json('Invalid msg data', ImBase::BUSINESS_NOT_EXIST_CODE);
        $this->serve->push($this->frame->fd, $errorData);
        return false;
    }

    /**
     * @param  object  $msgData
     * @return void|Response
     */
    protected function sendMsg(object $msgData): void
    {
        $msgData = MessagesController::me()->formatMsgData($msgData);
        $roomUser = $this->redis->hVals(RoomCache::ROOM_ONLINE.$msgData->room_id);
        foreach ($roomUser as $k => $v) {
            if (!$this->serve->isEstablished($v)) {
                // 如果连接不可用则忽略
                continue;
            }
            $this->serve->push($v, json_encode($msgData, 256));
        }
    }

    public static function me()
    {
        if (!(self::$me instanceof RoomController)) {
            self::$me = new self();
        }
        return self::$me;
    }

}