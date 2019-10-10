<?php


namespace App\Websocket\User;


use Hyperf\Contract\OnCloseInterface;
use Hyperf\Contract\OnMessageInterface;
use Hyperf\Contract\OnOpenInterface;
use Psr\Container\ContainerInterface;
use Swoole\Http\Request;
use Swoole\Server;
use Swoole\Websocket\Frame;
use Swoole\WebSocket\Server as WebSocketServer;


class WebsocketController implements OnMessageInterface, OnOpenInterface, OnCloseInterface
{
    public function __construct(ContainerInterface $container)
    {
    }

    public function onClose(Server $server, int $fd, int $reactorId): void
    {
        // TODO: Implement onClose() method.
    }

    public function onMessage(WebSocketServer $server, Frame $frame): void
    {
        // TODO: Implement onMessage() method.
    }

    public function onOpen(WebSocketServer $server, Request $request): void
    {
        // TODO: Implement onOpen() method.
    }
}