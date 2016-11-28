<?php

namespace CodeEmailMKT\Application\Action\Campaign;

use CodeEmailMKT\Domain\Service\CampaignReportInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use CodeEmailMKT\Domain\Persistence\CampaignRepositoryInterface;

class CampaignPrintReportPageAction
{
    /**
     * @var CampaignRepositoryInterface
     */
    private $repository;

    /**
     * @var CampaignReportInterface
     */
    private $report;

    public function __construct(CampaignRepositoryInterface $repository, CampaignReportInterface $report)
    {
        $this->repository = $repository;
        $this->report = $report;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $id = $request->getAttribute('id');
        $entity = $this->repository->find($id);
        $this->report->setCampaign($entity);
        return $this->report->render('app::campaign/print-report');
    }
}
