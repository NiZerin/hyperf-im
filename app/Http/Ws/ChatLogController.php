<?php


namespace App\Http\Ws;


class ChatLogController
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
        if (!(self::$_instance instanceof ChatLogController)){
            self::$_instance = new ChatLogController();
        }
        return self::$_instance;
    }

    public  function saveChatLog()
    {

    }
}