<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 6/13/2020
 * Time: 2:46 PM
 * FileName: api.php
 */

use App\Middleware\AuthMiddleware;
use Hyperf\HttpServer\Router\Router;

Router::addGroup('/api', function () {
    Router::addGroup('/user', function () {
        Router::post('/reg', 'Src\Home\api\User@reg');
        Router::post('/login', 'Src\Home\api\User@login');
    });

    Router::addGroup('/upload', function () {
        Router::post('/image', 'Src\Home\api\Upload@image');
        Router::post('/file', 'Src\Home\api\Upload@file');
    }, [
        'middleware' => [AuthMiddleware::class]
    ]);

    Router::addGroup('/group', function () {
        Router::post('/create', 'Src\Home\api\Group@create');
        Router::post('/join', 'Src\Home\api\Group@join');
    }, [
        'middleware' => [AuthMiddleware::class]
    ]);
});