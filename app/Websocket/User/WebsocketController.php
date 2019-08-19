<?php


namespace App\Websocket\User;


use Swoole\Server;
use Swoole\Http\Request;
use Swoole\Websocket\Frame;
use Hyperf\Contract\OnOpenInterface;
use Psr\Container\ContainerInterface;
use Hyperf\Contract\OnCloseInterface;
use Hyperf\Contract\OnMessageInterface;


class WebsocketController implements OnMessageInterface, OnOpenInterface, OnCloseInterface
{
    public function __construct(ContainerInterface $container)
    {
    }

    public function onClose(Server $server, int $fd, int $reactorId): void
    {
        // TODO: Implement onClose() method.
    }

    public function onMessage(Server $server, Frame $frame): void
    {
        // TODO: Implement onMessage() method.
    }

    public function onOpen(Server $server, Request $request): void
    {
        // TODO: Implement onOpen() method.
    }
}