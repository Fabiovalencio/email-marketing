<?php

use CodeEmailMKT\Application\Action\Customer\{
    CustomerListPageAction, CustomerCreatePageAction, CustomerUpdatePageAction, CustomerDeletePageAction
};
use CodeEmailMKT\Application\Action\Tag\{
    TagListPageAction, TagCreatePageAction, TagUpdatePageAction, TagDeletePageAction
};
use CodeEmailMKT\Application\Action\Campaign\CampaignUpdatePageAction;
use CodeEmailMKT\Application\Action\Campaign\{
    CampaignCreatePageAction, CampaignListPageAction, CampaignDeletePageAction, CampaignPrintReportPageAction, CampaignReportPageAction, CampaignSenderPageAction
};
use CodeEmailMKT\Application\Action\Customer\Factory as Customer;
use CodeEmailMKT\Application\Action\Tag\Factory as Tag;
use CodeEmailMKT\Application\Action\Campaign\Factory as Campaign;
use CodeEmailMKT\Application\Action\LoginPageAction;
use CodeEmailMKT\Application\Action\LoginPageFactory;
use CodeEmailMKT\Application\Action\LogoutAction;
use CodeEmailMKT\Application\Action\LogoutFactory;

return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\AuraRouter::class,
            CodeEmailMKT\Application\Action\PingAction::class => CodeEmailMKT\Application\Action\PingAction::class,
        ],
        'factories' => [
            CodeEmailMKT\Application\Action\HomePageAction::class => CodeEmailMKT\Application\Action\HomePageFactory::class,
            CodeEmailMKT\Application\Action\TestePageAction::class => CodeEmailMKT\Application\Action\TestePageFactory::class,
            LoginPageAction::class => LoginPageFactory::class,
            LogoutAction::class => LogoutFactory::class,
            CustomerListPageAction::class => Customer\CustomerListPageFactory::class,
            CustomerCreatePageAction::class => Customer\CustomerCreatePageFactory::class,
            CustomerUpdatePageAction::class => Customer\CustomerUpdatePageFactory::class,
            CustomerDeletePageAction::class => Customer\CustomerDeletePageFactory::class,
            TagListPageAction::class => Tag\TagListPageFactory::class,
            TagCreatePageAction::class => Tag\TagCreatePageFactory::class,
            TagUpdatePageAction::class => Tag\TagUpdatePageFactory::class,
            TagDeletePageAction::class => Tag\TagDeletePageFactory::class,
            CampaignListPageAction::class => Campaign\CampaignListPageFactory::class,
            CampaignCreatePageAction::class => Campaign\CampaignCreatePageFactory::class,
            CampaignUpdatePageAction::class => Campaign\CampaignUpdatePageFactory::class,
            CampaignDeletePageAction::class => Campaign\CampaignDeletePageFactory::class,
            CampaignSenderPageAction::class => Campaign\CampaignSenderPageFactory::class,
            CampaignReportPageAction::class => Campaign\CampaignReportPageFactory::class,
            CampaignPrintReportPageAction::class => Campaign\CampaignPrintReportPageFactory::class
        ],
    ],

    'routes' => [
        [
            'name' => 'home',
            'path' => '/',
            'middleware' => CodeEmailMKT\Application\Action\HomePageAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'auth.login',
            'path' => '/auth/login',
            'middleware' => LoginPageAction::class,
            'allowed_methods' => ['GET', 'POST'],
        ],
        [
            'name' => 'auth.logout',
            'path' => '/auth/logout',
            'middleware' => LogoutAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'customer.list',
            'path' => '/admin/customers',
            'middleware' => CustomerListPageAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'customer.create',
            'path' => '/admin/customer/create',
            'middleware' => CustomerCreatePageAction::class,
            'allowed_methods' => ['GET', 'POST'],
        ],
        [
            'name' => 'customer.update',
            'path' => '/admin/customer/{id}/update',
            'middleware' => CustomerUpdatePageAction::class,
            'allowed_methods' => ['GET', 'PUT'],
            'options' => [
                'tokens' => [
                    'id' => '\d+'
                ]
            ]
        ],
        [
            'name' => 'customer.delete',
            'path' => '/admin/customer/{id}/delete',
            'middleware' => CustomerDeletePageAction::class,
            'allowed_methods' => ['DELETE'],
            'options' => [
                'tokens' => [
                    'id' => '\d+'
                ]
            ]
        ],
        [
            'name' => 'tag.list',
            'path' => '/admin/tags',
            'middleware' => TagListPageAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'tag.create',
            'path' => '/admin/tag/create',
            'middleware' => TagCreatePageAction::class,
            'allowed_methods' => ['GET', 'POST'],
        ],
        [
            'name' => 'tag.update',
            'path' => '/admin/tag/{id}/update',
            'middleware' => TagUpdatePageAction::class,
            'allowed_methods' => ['GET', 'PUT'],
            'options' => [
                'tokens' => [
                    'id' => '\d+'
                ]
            ]
        ],
        [
            'name' => 'tag.delete',
            'path' => '/admin/tag/{id}/delete',
            'middleware' => TagDeletePageAction::class,
            'allowed_methods' => ['DELETE'],
            'options' => [
                'tokens' => [
                    'id' => '\d+'
                ]
            ]
        ],
        [
            'name' => 'campaign.list',
            'path' => '/admin/campaign',
            'middleware' => CampaignListPageAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'campaign.create',
            'path' => '/admin/campaign/create',
            'middleware' => CampaignCreatePageAction::class,
            'allowed_methods' => ['GET', 'POST'],
        ],
        [
            'name' => 'campaign.update',
            'path' => '/admin/campaign/{id}/update',
            'middleware' => CampaignUpdatePageAction::class,
            'allowed_methods' => ['GET', 'PUT'],
            'options' => [
                'tokens' => [
                    'id' => '\d+'
                ]
            ]
        ],
        [
            'name' => 'campaign.delete',
            'path' => '/admin/campaign/{id}/delete',
            'middleware' => CampaignDeletePageAction::class,
            'allowed_methods' => ['DELETE'],
            'options' => [
                'tokens' => [
                    'id' => '\d+'
                ]
            ]
        ],
        [
            'name' => 'campaign.sender',
            'path' => '/admin/campaign/{id}/sender',
            'middleware' => CampaignSenderPageAction::class,
            'allowed_methods' => ['GET', 'POST'],
            'options' => [
                'tokens' => [
                    'id' => '\d+'
                ]
            ]
        ],
        [
            'name' => 'campaign.report',
            'path' => '/admin/campaign/{id}/report',
            'middleware' => CampaignReportPageAction::class,
            'allowed_methods' => ['GET'],
            'options' => [
                'tokens' => [
                    'id' => '\d+'
                ]
            ]
        ],
        [
            'name' => 'campaign.print-report',
            'path' => '/admin/campaign/{id}/print-report',
            'middleware' => CampaignPrintReportPageAction::class,
            'allowed_methods' => ['GET', 'POST'],
            'options' => [
                'tokens' => [
                    'id' => '\d+'
                ]
            ]
        ]
    ],
];
