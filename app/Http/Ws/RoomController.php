<?php


namespace App\Http\Ws;


use App\Controller\BaseController;

class RoomController extends BaseController
{
    const LOGIN_ROOM = 'login_room';
    const SEND_MSG = 'send_msg';
    const ROOM_ONLINE = 'ROOM_ONLINE_USER:';
    const USER_TOKEN = 'USER_TOKEN';
    const USER_ON_ROOM = 'USER_ON_ROOM';
    const USER_BIND_FD = 'USER_BIND_FD';
    const AppKey = '6417de28177a35111556438891d050ad';

    protected $serve;
    protected $frame;

    public function CheckData($frame, $serve)
    {
        $this->serve = $serve;
        $this->frame = $frame;

        var_dump($frame->data);
        $msgData = json_decode($frame->data, true);
        if (is_array($msgData)) {
            if (key_exists(self::LOGIN_ROOM, $msgData)) {
                return $this->joinRoom($msgData);
            }
            if (key_exists(self::SEND_MSG, $msgData)) {
                return $this->sendMsg($msgData);
            }
            $errorData = ImBase::json('Invalid msg data',ImBase::BUSINESS_NOT_EXIST_CODE);
            $this->serve->push($this->frame->fd, $errorData);
        }
        return false;
    }


    protected function sendMsg(array $msgData)
    {
        $roomUser = $this->cache->hKeys(self::ROOM_ONLINE.$msgData[self::SEND_MSG]);
        foreach ($roomUser as $k => $v){
            $this->serve->push($v,$msgData['content']);
        }
    }

    public function outRoom(int $fd)
    {
        $fd = (string)$fd;
        $imId = $this->cache->hGet(self::USER_BIND_FD,$fd);
        $roomId = $this->cache->hGet(self::USER_ON_ROOM, $imId);
        $this->cache->hDel(self::ROOM_ONLINE.$roomId, $imId);
        $this->cache->hDel(self::USER_ON_ROOM, $imId);
        $this->cache->hDel(self::USER_BIND_FD, $fd);
    }

    protected function joinRoom(array $joinInfo)
    {
        /*
         * take im user in room cache
         */
        $this->cache->hSet(self::ROOM_ONLINE.$joinInfo[self::LOGIN_ROOM], $joinInfo['im_id'], $this->frame->fd);
        /*
         * bind im user to room id
         */
        $this->cache->hSet(self::USER_ON_ROOM, $joinInfo['im_id'], $joinInfo[self::LOGIN_ROOM]);
        /*
         * bind websocket fd to im user
         */
        $this->cache->hSet(self::USER_BIND_FD, (string)$this->frame->fd, $joinInfo['im_id']);
        /*
         * create im user token
         */
        $this->createToken($joinInfo);
    }


    /**
     * @param  array  $joinInfo
     * @return bool
     */
    protected function createToken(array $joinInfo)
    {
        $secret = md5($joinInfo['im_id'].$joinInfo['time'].$joinInfo[self::LOGIN_ROOM].self::AppKey);

        if ($secret != $joinInfo['secret']) {
            $errorData = ImBase::json('Invalid connection , bcz check secret failed', ImBase::BUSINESS_SERVICE_NOT_AVAILABLE_CODE);
            $this->serve->push($this->frame->fd, $errorData);
            return false;
        }

        if ($secret == $secret){
            $token = md5($secret);
            $this->cache->hSet(self::USER_TOKEN, $joinInfo['im_id'], $token);
            $loginData = [
                'token' => $token,
                'room_id' => $joinInfo[self::LOGIN_ROOM]
            ];
            $successDate = ImBase::json('Successful connection',ImBase::BUSINESS_SUCCESS_CODE, $loginData);
            $this->serve->push($this->frame->fd, $successDate);
            return true;
        }

        return false;
    }
}