<?php


namespace App\Controller;


use Psr\Container\ContainerInterface;

class BaseController extends Controller
{

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
    }

}