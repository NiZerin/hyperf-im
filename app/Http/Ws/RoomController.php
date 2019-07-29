<?php


namespace App\Http\Ws;


use App\Controller\BaseController;
use App\Model\LiveImInfo;
use App\Model\LiveImRoom;

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

        if (key_exists(self::LOGIN_ROOM, $msgData)) {
            if (!$this->checkRoom($msgData[self::LOGIN_ROOM])) {
                return false;
            }
            if (!$this->checkIm($msgData['im_id'])) {
                return false;
            }
            $this->joinRoom($msgData);
            return true;
        }
        if (key_exists(self::SEND_MSG, $msgData)) {
            return $this->sendMsg($msgData);
        }

        $errorData = ImBase::json('Invalid msg data', ImBase::BUSINESS_NOT_EXIST_CODE);
        $this->serve->push($this->frame->fd, $errorData);
        return false;
    }

    /**
     * @param  array  $msgData
     * @return bool
     */
    protected function sendMsg(array $msgData): bool
    {
        $checkToken = $this->checkToKen($msgData['im_id'], $msgData['token']);
        if (!$checkToken) {
            return false;
        } else {
            $roomUser = $this->cache->hVals(self::ROOM_ONLINE.$msgData[self::SEND_MSG]);
            foreach ($roomUser as $k => $v) {
                $this->serve->push($v, $msgData['content']);
            }
            return true;
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
     * @param  array  $joinInfo
     */
    protected function joinRoom(array $joinInfo): void
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
     * @param  string  $imId
     * @return bool
     */
    protected function checkIm(string $imId)
    {
        $imInfo = LiveImInfo::query()->where('im_id', $imId)->first();
        if (is_null($imInfo)) {
            $errorData = ImBase::json('im user nonexistent , pls check again', ImBase::BUSINESS_NOT_EXIST_CODE);
            $this->serve->push($this->frame->fd, $errorData);
            return false;
        } else {
            return true;
        }
    }

    /**
     * check im token
     * @param  string  $imId
     * @param  string  $token
     * @return bool
     */
    protected function checkToKen(string $imId, string $token): bool
    {
        $imToken = $this->cache->hGet(self::USER_TOKEN, $imId);
        if ($imToken != $token) {
            $errorData = ImBase::json('Invalid msg data , bcz check token failed', ImBase::BUSINESS_ARG_NOT_CORRECT_CODE);
            $this->serve->push($this->frame->fd, $errorData);
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param  int  $roomId
     * @return bool
     */
    protected function checkRoom(int $roomId)
    {
        $roomInfo = LiveImRoom::query()->where('room_id', $roomId)->first();
        if (is_null($roomInfo)) {
            $errorData = ImBase::json('room nonexistent , pls check again', ImBase::BUSINESS_NOT_EXIST_CODE);
            $this->serve->push($this->frame->fd, $errorData);
            return false;
        } else {
            return true;
        }
    }

    /**
     * create im token
     * @param  array  $joinInfo
     * @return void
     */
    protected function createToken(array $joinInfo): void
    {
        $secret = md5($joinInfo['im_id'].$joinInfo['time'].$joinInfo[self::LOGIN_ROOM].self::AppKey);

        if ($secret != $joinInfo['secret']) {
            $errorData = ImBase::json('Invalid connection , bcz check secret failed', ImBase::BUSINESS_SERVICE_NOT_AVAILABLE_CODE);
            $this->serve->push($this->frame->fd, $errorData);
        }

        if ($secret == $secret) {
            $token = md5($secret);
            $this->cache->hSet(self::USER_TOKEN, $joinInfo['im_id'], $token);
            $loginData = [
                'token' => $token,
                'room_id' => $joinInfo[self::LOGIN_ROOM]
            ];
            $successDate = ImBase::json('Successful connection', ImBase::BUSINESS_SUCCESS_CODE, $loginData);
            $this->serve->push($this->frame->fd, $successDate);
        }
    }
}