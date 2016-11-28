<?php

namespace CodeEmailMKT\Application\Action\Campaign\Factory;

use CodeEmailMKT\Application\Action\Campaign\CampaignPrintReportPageAction;
use CodeEmailMKT\Domain\Service\CampaignReportInterface;
use Interop\Container\ContainerInterface;
use CodeEmailMKT\Domain\Persistence\CampaignRepositoryInterface;

class CampaignPrintReportPageFactory
{
    public function __invoke(ContainerInterface $container) : CampaignPrintReportPageAction
    {
        $repository = $container->get(CampaignRepositoryInterface::class);
        $report = $container->get(CampaignReportInterface::class);
        return new CampaignPrintReportPageAction($repository, $report);
    }
}
