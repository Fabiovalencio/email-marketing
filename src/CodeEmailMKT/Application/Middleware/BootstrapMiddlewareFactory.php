<?php

namespace CodeEmailMKT\Application\Middleware;

use CodeEmailMKT\Infrastructure\Bootstrap;
use Interop\Container\ContainerInterface;
use CodeEmailMKT\Domain\Service\FlashMessageInterface;

class BootstrapMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $bootstrap = new Bootstrap();
        $flashMessage = $container->get(FlashMessageInterface::class);
        return new BootstrapMiddleware($bootstrap, $flashMessage);
    }
}