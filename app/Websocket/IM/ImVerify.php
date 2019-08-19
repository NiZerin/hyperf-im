<?php


namespace App\Websocket\IM;


use App\Http\Ws\ImBase;
use App\Model\LiveImInfo;
use App\Model\LiveImRoom;

class ImVerify
{
    protected $serve = null;
    protected $frame = null;
    private static $me = null;

    public function __construct()
    {
        $this->serve = server();
        $this->frame = frame();
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
        $imToken = LiveImInfo::query()->where('im_id', $imId)->first();
        if ($imToken->im_token != $token) {
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
     * verify im id and token , room id
     * @param  object  $msgData
     * @return bool
     */
    public function verifyData(object $msgData) :bool
    {
        if (!$this->checkRoom($msgData->room_id)) {
            return false;
        }
        if (!$this->checkIm($msgData->im_id)) {
            return false;
        }
        if (!$this->checkToKen($msgData->im_id, $msgData->im_token)){
            return false;
        }
        return true;
    }

    public static function me()
    {
        if (!(self::$me instanceof ImVerify)) {
            self::$me = new self();
        }
        return self::$me;
    }

}