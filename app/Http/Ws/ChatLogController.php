<?php


namespace App\Http\Ws;


use Hyperf\Task\Task;
use Hyperf\Task\TaskExecutor;
use Hyperf\Utils\ApplicationContext;

class ChatLogController
{

    //存放实例 私有静态变量
    private static $_instance = null;

    //私有化构造方法、
    private function __construct()
    {
        echo "单例模式的实例被构造了\n";
    }

    //私有化克隆方法
    private function __clone()
    {

    }

    //公有化获取实例方法
    public static function getInstance()
    {
        if (!(self::$_instance instanceof ChatLogController)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @param $msgData
     */
    public static function handle($msgData)
    {
        go(function () use ($msgData) {

        });
    }

    /**
     * @param $msgData
     */
    public function saveChatLog($msgData)
    {
        $container = ApplicationContext::getContainer();
        $exec = $container->get(TaskExecutor::class);
        $result = $exec->execute(new Task([ChatLogController::class, 'handle'], [$msgData]));
        unset($result);
    }

    public function __call($name, $arguments)
    {
        return $this->$name(...$arguments);
        // TODO: Implement __call() method.
    }

    public static function __callStatic($name, $arguments)
    {
        return static::$name(...$arguments);
        // TODO: Implement __callStatic() method.
    }
}