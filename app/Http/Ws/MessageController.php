<?php


namespace App\Http\Ws;


use Faker\Provider\Uuid;

class MessageController
{
    //存放实例 私有静态变量
    private static $_instance = null;

    //私有化构造方法、
    private function __construct(){
        echo "单例模式的实例被构造了";
    }
    //私有化克隆方法
    private function __clone(){

    }

    //公有化获取实例方法
    public static function getInstance(){
        if (!(self::$_instance instanceof MessageController)){
            self::$_instance = new MessageController();
        }
        return self::$_instance;
    }

    public function formatMsgData(object $msgData) :object
    {
        $msgData->msg_id = Uuid::uuid();
        $msgData->time = time();
        unset($msgData->im_token);
        $msgData->msg_type = 'new_msg';

        return $msgData;
    }

}