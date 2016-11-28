<?php

namespace CodeEmailMKT\Infrastructure\Service;

use Aura\Session\Session;
use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;
use CodeEmailMKT\Domain\Service\AuthInterface;
use Interop\Container\ContainerInterface;
use Mailgun\Mailgun;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Mvc\Controller\Plugin\FlashMessenger;

class CampaignEmailSenderFactory
{
    public function __invoke(ContainerInterface $container) : CampaignEmailSender
    {
        $template = $container->get(TemplateRendererInterface::class);
        $mailgun = $container->get(Mailgun::class);
        $mailgunConfig = $container->get('config')['mailgun'];
        $auth = $container->get(AuthInterface::class);
        $repository = $container->get(CustomerRepositoryInterface::class);
        return new CampaignEmailSender($template, $mailgun, $mailgunConfig, $auth, $repository);
    }
}
