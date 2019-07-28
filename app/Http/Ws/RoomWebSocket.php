<?php
declare(strict_types=1);

namespace App\Http\Ws;

use Hyperf\Contract\{OnCloseInterface, OnMessageInterface, OnOpenInterface};
use Psr\Container\ContainerInterface;
use Swoole\Http\Request;
use Swoole\Server;
use Swoole\Websocket\Frame;

class RoomWebSocket implements OnMessageInterface, OnOpenInterface, OnCloseInterface
{

    protected $user;
    protected $room;

    public function __construct(ContainerInterface $container)
    {
        $this->user = new UserController($container);
        $this->room = new RoomController($container);
    }

    public function onMessage(Server $server, Frame $frame): void
    {
        $data = json_decode($frame->data, true);
        if (is_array($data)) {
            $this->room->CheckData($frame, $server);
            # $server->push($frame->fd, $frame->data);
        } else {
            $errorData = ImBase::json('Illegal connection',ImBase::BUSINESS_NOT_EXIST_CODE);
            $server->push($frame->fd, $errorData);
        }
    }

    public function onClose(Server $server, int $fd, int $reactorId): void
    {
        $this->room->outRoom($fd);
//        $this->user->setUserOutline($fd);
        var_dump('closed'.$fd);
    }

    public function onOpen(Server $server, Request $request): void
    {
//        $this->user->setUserOnline($request->fd);
        $openData = ImBase::json('Opened '.$request->fd.', pls check secret',ImBase::BUSINESS_SUCCESS_CODE);
        $server->push($request->fd, $openData);
    }

}