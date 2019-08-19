<?php


namespace App\Websocket\Room;


use App\Websocket\IM\ImBase;
use App\Websocket\IM\ImTools;
use App\Websocket\Websocket;
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
        RoomCache::me()->outRoom($fd);
        var_dump('closed'.$fd);
    }

    public function onMessage(Server $server, Frame $frame): void
    {
        Websocket::setFrame($frame);
        $data = json_decode($frame->data);
        if (is_object($data)) {
            RoomController::me()->checkData($data);
        } else {
            $errorData = ImTools::json('Invalid connection',ImBase::BUSINESS_NOT_EXIST_CODE);
            $server->push($frame->fd, $errorData);
        }
    }

    public function onOpen(Server $server, Request $request): void
    {
        $openData = ImTools::json('Opened '.$request->fd.', pls check secret',ImBase::BUSINESS_SUCCESS_CODE);
        $server->push($request->fd, $openData);
    }
}