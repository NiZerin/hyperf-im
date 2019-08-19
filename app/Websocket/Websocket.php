<?php


namespace App\Websocket;


class Websocket
{
    protected $serve = null;
    protected $frame = null;
    protected $redis = null;
    protected $container = null;

    public function __construct()
    {
//        $this->frame = frame();
        $this->redis = redis();
        $this->serve = server();
        $this->container = container();
    }

    public function frame($frame)
    {
        $this->frame = $frame;
    }

    public static function setFrame($frame)
    {
         (new Websocket)->frame($frame);
    }
}