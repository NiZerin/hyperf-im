<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 2020/7/3
 * Time: 15:56
 * FileName: AppServerStartListener.php
 */


namespace App\Listener;


use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Framework\Event\BeforeMainServerStart;

class AppServerStartListener implements ListenerInterface
{
    private $logger;

    public function __construct(StdoutLoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return string[]
     */
    public function listen(): array
    {
        return [
            BeforeMainServerStart::class
        ];
    }

    /**
     * @param  object  $event
     */
    public function process(object $event)
    {
        $this->logger->debug("Hyperf-im Starting................");

        go(function () {
            redis()->select((int)env('REDIS_DB'));
            redis()->flushDB();
        });

        $this->logger->debug("Hyperf-im Success.................");
    }
}