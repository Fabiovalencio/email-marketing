<?php

namespace CodeEmailMKT\Infrastructure\Service;

use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;
use CodeEmailMKT\Domain\Service\AuthInterface;
use Interop\Container\ContainerInterface;
use Mailgun\Mailgun;
use Zend\Expressive\Template\TemplateRendererInterface;

class CampaignDeleteFactory
{
    public function __invoke(ContainerInterface $container) : CampaignDelete
    {
        $template = $container->get(TemplateRendererInterface::class);
        $mailgun = $container->get(Mailgun::class);
        $mailgunConfig = $container->get('config')['mailgun'];
        $auth = $container->get(AuthInterface::class);
        $repository = $container->get(CustomerRepositoryInterface::class);
        return new CampaignDelete($template, $mailgun, $mailgunConfig, $auth, $repository);
    }
}
