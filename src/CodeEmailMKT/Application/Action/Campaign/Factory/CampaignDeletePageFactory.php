<?php

namespace CodeEmailMKT\Application\Action\Campaign\Factory;

use CodeEmailMKT\Application\Action\Campaign\CampaignDeletePageAction;
use CodeEmailMKT\Application\Form\CampaignForm;
use CodeEmailMKT\Domain\Service\CampaignDeleteInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use CodeEmailMKT\Domain\Persistence\CampaignRepositoryInterface;

class CampaignDeletePageFactory
{
    public function __invoke(ContainerInterface $container) : CampaignDeletePageAction
    {
        $template = $container->get(TemplateRendererInterface::class);
        $repository = $container->get(CampaignRepositoryInterface::class);
        $router = $container->get(RouterInterface::class);
        $form = $container->get(CampaignForm::class);
        $emailDelete = $container->get(CampaignDeleteInterface::class);
        return new CampaignDeletePageAction($repository, $template, $router, $form, $emailDelete);
    }
}
