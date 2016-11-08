<?php

use Zend\Expressive\Application;
use Zend\Expressive\Container\ApplicationFactory;
use Zend\Expressive\Helper;
use CodeEmailMKT\Infrastructure\Persistence\Doctrine\Repository\CustomerRepositoryFactory;
use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;
use Aura\Session\Session;
use DaMess\Factory\AuraSessionFactory;
use CodeEmailMKT\Infrastructure\Service\FlashMessageFactory;
use CodeEmailMKT\Domain\Service\FlashMessageInterface;

return [
    // Provides application-wide services.
    // We recommend using fully-qualified class names whenever possible as
    // service names.
    'dependencies' => [
        // Use 'invokables' for constructor-less services, or services that do
        // not require arguments to the constructor. Map a service name to the
        // class name.
        'invokables' => [
            // Fully\Qualified\InterfaceName::class => Fully\Qualified\ClassName::class,
            Helper\ServerUrlHelper::class => Helper\ServerUrlHelper::class,
        ],
        // Use 'factories' for services provided by callbacks/factory classes.
        'factories' => [
            Application::class => ApplicationFactory::class,
            Helper\UrlHelper::class => Helper\UrlHelperFactory::class,
            CustomerRepositoryInterface::class => CustomerRepositoryFactory::class,
            Session::class => AuraSessionFactory::class,
            FlashMessageInterface::class => FlashMessageFactory::class,

        ],
        'aliases' => [
            'configuration' => 'config', //Doctrine needs a service called Configuration
        ],
    ],
];
