<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 6/12/2020
 * Time: 2:11 PM
 * FileName: helper.php
 */


use Hyperf\Utils\ApplicationContext;

if (!function_exists('container')) {
    /**
     * 容器示例
     * @return \Psr\Container\ContainerInterface
     */
    function container()
    {
        return ApplicationContext::getContainer();
    }
}

if (!function_exists('redis')) {
    /**
     * redis 客户端示例
     * @return mixed|\Redis
     */
    function redis()
    {
        return container()->get(Redis::class);
    }
}