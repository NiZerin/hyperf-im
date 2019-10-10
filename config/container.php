<?php
/**
 * Initial a dependency injection container that implemented PSR-11 and return the container.
 */
declare(strict_types=1);

use Hyperf\Di\Container;
use Hyperf\Di\Definition\DefinitionSourceFactory;
use Hyperf\Utils\ApplicationContext;
use Psr\Container\ContainerInterface;

$container = new Container((new DefinitionSourceFactory(true))());
if (! $container instanceof ContainerInterface) {
    throw new RuntimeException('The dependency injection container is invalid.');
}
return ApplicationContext::setContainer($container);
