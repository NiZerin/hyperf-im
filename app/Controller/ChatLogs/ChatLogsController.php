<?php


namespace App\Controller\ChatLogs;


use App\Http\Ws\ChatLogController;
use Hyperf\Task\Task;
use Hyperf\Task\TaskExecutor;
use Hyperf\Utils\ApplicationContext;

class ChatLogsController
{
    private static $me = null;
    /**
     * @param $msgData
     */
    public function handle($msgData)
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

    public static function me()
    {
        if (!(self::$me instanceof ChatLogController)) {
            self::$me = new self();
        }
        return self::$me;
    }
}