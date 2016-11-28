<?php

use CodeEmailMKT\Application\Form\Factory\{
    CampaignFormFactory, CustomerFormFactory, LoginFormFactory, TagFormFactory
};
use CodeEmailMKT\Application\Form\{
    CampaignForm, CustomerForm, LoginForm, TagForm
};
use CodeEmailMKT\Infrastructure\View\HelperPluginManagerFactory;
use Zend\Form\ConfigProvider;
use Zend\Stdlib\ArrayUtils;
use Zend\View\HelperPluginManager;

$forms = [
    'dependencies' => [
        'aliases' => [

        ],
        'invokables' => [

        ],
        'factories' => [
            HelperPluginManager::class => HelperPluginManagerFactory::class,
            CustomerForm::class => CustomerFormFactory::class,
            LoginForm::class => LoginFormFactory::class,
            TagForm::class => TagFormFactory::class,
            CampaignForm::class => CampaignFormFactory::class
        ]
    ],
    'view_helpers' => [
        'aliases' => [

        ],
        'invokables' => [

        ],
        'factories' => [
            'identity' => \Zend\View\Helper\Service\IdentityFactory::class
        ]
    ]
];

$configProviderForm = (new ConfigProvider())->__invoke();

return ArrayUtils::merge($configProviderForm, $forms);