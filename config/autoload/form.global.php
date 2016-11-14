<?php

use CodeEmailMKT\Application\Form;
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
            Form\CustomerForm::class => Form\Factory\CustomerFormFactory::class,
            Form\LoginForm::class => Form\Factory\LoginFormFactory::class
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