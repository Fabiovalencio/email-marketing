<?php

namespace CodeEmailMKT\Application\Action\Campaign\Factory;

use CodeEmailMKT\Application\Action\Campaign\CampaignSenderPageAction;
use CodeEmailMKT\Application\Form\CampaignForm;
use CodeEmailMKT\Domain\Service\CampaignEmailSenderInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use CodeEmailMKT\Domain\Persistence\CampaignRepositoryInterface;

class CampaignSenderPageFactory
{
    public function __invoke(ContainerInterface $container) : CampaignSenderPageAction
    {
        $template = $container->get(TemplateRendererInterface::class);
        $repository = $container->get(CampaignRepositoryInterface::class);
        $router = $container->get(RouterInterface::class);
        $form = $container->get(CampaignForm::class);
        $emailSender = $container->get(CampaignEmailSenderInterface::class);
        return new CampaignSenderPageAction($repository, $template, $router, $form, $emailSender);
    }
}
