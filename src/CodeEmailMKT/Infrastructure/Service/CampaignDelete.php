<?php

namespace CodeEmailMKT\Infrastructure\Service;

use CodeEmailMKT\Domain\Entity\Campaign;
use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;
use CodeEmailMKT\Domain\Service\AuthInterface;
use CodeEmailMKT\Domain\Service\CampaignDeleteInterface;
use Mailgun\Connection\Exceptions\MissingEndpoint;
use Mailgun\Mailgun;
use Mailgun\Messages\BatchMessage;
use Zend\Expressive\Template\TemplateRendererInterface;

class CampaignDelete implements CampaignDeleteInterface
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
     * @var AuthInterface
     */
    private $auth;

    /**
     * @var CustomerRepositoryInterface
     */
    private $repository;

    /**
     * CampaignEmailSender constructor.
     */
    public function __construct(TemplateRendererInterface $templateRenderer, Mailgun $mailgun, array $mailgunConfig, AuthInterface $auth, CustomerRepositoryInterface $repository)
    {
        $this->templateRenderer = $templateRenderer;
        $this->mailgunConfig = $mailgunConfig;
        $this->mailgun = $mailgun;
        $this->auth = $auth;
        $this->repository = $repository;
    }

    public function setCampaign(Campaign $campaign)
    {
        $this->campaign = $campaign;
        return $this;
    }

    public function deleteCampaign()
    {
        $check = $this->checkMailgunCampaign();

        $check ? $this->deleteMailgunCampaign() : false;

        $this->repository->remove($this->campaign);
    }

    protected function deleteMailgunCampaign()
    {
        $domain = $this->mailgunConfig['domain'];
        try{
            $this->mailgun->delete("$domain/campaigns/campaign_{$this->campaign->getId()}");
        } catch (MissingEndpoint $e) {
            return false;
        }
    }

    protected function checkMailgunCampaign()
    {
        $domain = $this->mailgunConfig['domain'];
        try{
            $this->mailgun->get("$domain/campaigns/campaign_{$this->campaign->getId()}");
            return true;
        } catch (MissingEndpoint $e) {
            return false;
        }
    }
}