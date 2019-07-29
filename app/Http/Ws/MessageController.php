<?php


namespace App\Http\Ws;


use Faker\Provider\Uuid;

class MessageController
{
    //存放实例 私有静态变量
    private static $_instance = null;

    protected $serve = null;

    //私有化构造方法、
    private function __construct($serve){
        $this->serve = $serve;
        echo "单例模式的实例被构造了";
    }
    //私有化克隆方法
    private function __clone(){

    }

    //公有化获取实例方法
    public static function getInstance($serve){
        if (!(self::$_instance instanceof MessageController)){
            self::$_instance = new MessageController($serve);
        }
        return self::$_instance;
    }

    public function formatMsgData(object $msgData) :object
    {
        $msgData->msg_id = Uuid::uuid();
        $msgData->time = time();
        $msgData->opt_type = 'new_msg';

//        $method = 'check'.ucfirst($msgData->content->msg_type);
//        $this->$method($msgData);


        unset($msgData->im_token);
        return $msgData;
    }


    protected function checkText(object $msgData)
    {

    }

}