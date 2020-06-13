<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 6/13/2020
 * Time: 2:46 PM
 * FileName: server.php
 */

use Hyperf\HttpServer\Router\Router;

Router::addServer('ws', function () {
    Router::get('/', 'Src\WebSocket\Service');
});