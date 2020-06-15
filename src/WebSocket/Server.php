<?php
declare(strict_types=1);

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 4/30/2020
 * Time: 5:26 PM
 * FileName: Controller.php
 */


namespace Src\WebSocket;

use Hyperf\Contract\OnCloseInterface;
use Hyperf\Contract\OnMessageInterface;
use Hyperf\Contract\OnOpenInterface;
use Swoole\Http\Request;
use Swoole\Server as SwooleServer;
use Swoole\Websocket\Frame;
use Swoole\WebSocket\Server as WebSocketServer;

/**
 * Class Service
 *
 * @package Src\WebSocket
 */
class Server implements OnMessageInterface, OnOpenInterface, OnCloseInterface
{
    /**
     * @param  \Swoole\WebSocket\Server  $server
     * @param  \Swoole\Websocket\Frame  $frame
     */
    public function onMessage(WebSocketServer $server, Frame $frame): void
    {
        Message::switch($frame, $server);
    }

    /**
     * @param  \Swoole\Server  $server
     * @param  int  $fd
     * @param  int  $reactorId
     */
    public function onClose(SwooleServer $server, int $fd, int $reactorId): void
    {
        User::setOutline($fd);
    }

    /**
     * @param  \Swoole\WebSocket\Server  $server
     * @param  \Swoole\Http\Request  $request
     */
    public function onOpen(WebSocketServer $server, Request $request): void
    {
        $check = Auth::checkToken($request->get ?? []);

        if (is_bool($check)) {
            $server->push($request->fd, error('token check failed'));
            $server->close($request->fd);
        } else {
            User::setOnline($check, $request->fd);
            $server->push($request->fd, success('login success'));
        }
    }
}