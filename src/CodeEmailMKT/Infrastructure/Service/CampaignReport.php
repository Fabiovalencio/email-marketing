<?php

namespace CodeEmailMKT\Infrastructure\Service;

use CodeEmailMKT\Domain\Entity\Campaign;
use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;
use CodeEmailMKT\Domain\Service\CampaignReportInterface;
use Mailgun\Mailgun;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class CampaignReport implements CampaignReportInterface
{
    /**
     * @var Campaign
     */
    private $campaign;

    /**
     * @var TemplateRendererInterface
     */
    private $templateRenderer;

    /**
     * @var Mailgun
     */
    private $mailgun;

    /**
     * @var Mailgun
     */
    private $mailgunConfig;

    /**
     * @var CustomerRepositoryInterface
     */
    private $repository;

    /**
     * CampaignEmailSender constructor.
     */
    public function __construct(TemplateRendererInterface $templateRenderer, Mailgun $mailgun, array $mailgunConfig, CustomerRepositoryInterface $repository)
    {
        $this->templateRenderer = $templateRenderer;
        $this->mailgunConfig = $mailgunConfig;
        $this->mailgun = $mailgun;
        $this->repository = $repository;
    }

    public function setCampaign(Campaign $campaign) : CampaignReport
    {
        $this->campaign = $campaign;
        return $this;
    }

    public function render(string $template) : ResponseInterface
    {
        return new HtmlResponse($this->templateRenderer->render($template, [
            'campaign_data' => $this->getCampaignData(),
            'campaign' => $this->campaign,
            'customers_count' => $this->getCountCustomers(),
            'opened_distinct_count' => $this->getCountOpenedDistinct()
        ]));
    }

    protected function getCampaignData()
    {
        $domain = $this->mailgunConfig['domain'];
        $response = $this->mailgun->get("$domain/campaigns/campaign_{$this->campaign->getId()}");
        return $response->http_response_body;
    }

    protected function getCountOpenedDistinct()
    {
        $domain = $this->mailgunConfig['domain'];
        $response = $this->mailgun->get("$domain/campaigns/campaign_{$this->campaign->getId()}/opens", [
            'groupby' => 'recipient',
            'count' => true
        ]);

        return $response->http_response_body->count;
    }

    protected function getCountCustomers()
    {
        $tags = $this->campaign->getTags()->toArray();
        $customers = $this->repository->findByTags($tags);
        return count($customers);
    }
}