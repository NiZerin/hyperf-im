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
use Swoole\Websocket\Frame;

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
    public function onMessage($server, Frame $frame): void
    {
        Enter::message($frame, $server);
    }

    /**
     * @param  \Swoole\Server  $server
     * @param  int  $fd
     * @param  int  $reactorId
     */
    public function onClose($server, int $fd, int $reactorId): void
    {
        Enter::close($server, $fd);
    }

    /**
     * @param  \Swoole\WebSocket\Server  $server
     * @param  \Swoole\Http\Request  $request
     */
    public function onOpen($server, Request $request): void
    {
        Enter::open($server, $request);
    }
}