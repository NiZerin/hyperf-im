<?php


namespace App\Controller\Messages;


use Faker\Provider\Uuid;

class MessagesController
{
    private static $me = null;

    public function formatMsgData(object $msgData) :object
    {
        $msgData->msg_id = Uuid::uuid();
        $msgData->time = time();
        $msgData->opt_type = 'new_msg';
//        ChatLogController::getInstance()->saveChatLog($msgData);
//        $method = 'check'.ucfirst($msgData->content->msg_type);
//        $this->$method($msgData);

        unset($msgData->im_token);
        return $msgData;
    }


    protected function checkText(object $msgData)
    {

    }

    public static function me()
    {
        if (!(self::$me instanceof MessagesController)) {
            self::$me = new self();
        }
        return self::$me;
    }
}