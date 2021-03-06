<?php

use CodeEmailMKT\Domain\Persistence\CampaignRepositoryInterface;
use CodeEmailMKT\Domain\Service\AuthInterface;
use CodeEmailMKT\Domain\Service\CampaignDeleteInterface;
use CodeEmailMKT\Domain\Service\CampaignEmailSenderInterface;
use CodeEmailMKT\Domain\Service\CampaignReportInterface;
use Mailgun\Mailgun;
use Zend\Authentication\AuthenticationService;
use Zend\Expressive\Application;
use Zend\Expressive\Container\ApplicationFactory;
use Zend\Expressive\Helper;
use CodeEmailMKT\Infrastructure\Service;
use CodeEmailMKT\Infrastructure\Persistence\Doctrine\Repository\{
    CustomerRepositoryFactory, TagRepositoryFactory, CampaignRepositoryFactory
};
use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;
use CodeEmailMKT\Domain\Persistence\TagRepositoryInterface;
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
            FlashMessageInterface::class => Service\FlashMessageFactory::class,
            'doctrine:fixture_cmd:load' => \CodeEdu\FixtureFactory::class,
            AuthInterface::class => Service\AuthServiceFactory::class,
            TagRepositoryInterface::class => TagRepositoryFactory::class,
            CampaignRepositoryInterface::class => CampaignRepositoryFactory::class,
            Mailgun::class => Service\MailgunFactory::class,
            CampaignEmailSenderInterface::class => Service\CampaignEmailSenderFactory::class,
            CampaignReportInterface::class => Service\CampaignReportFactory::class,
            CampaignDeleteInterface::class => Service\CampaignDeleteFactory::class
        ],
        'aliases' => [
            'Configuration' => 'config', //Doctrine needs a service called Configuration
            'Config' => 'config',
            AuthenticationService::class => 'doctrine.authenticationservice.orm_default'
        ],
    ],
];
