<?php

namespace CodeEmailMKT\Infrastructure\Service;

use CodeEmailMKT\Domain\Entity\Campaign;
use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;
use CodeEmailMKT\Domain\Service\AuthInterface;
use CodeEmailMKT\Domain\Service\CampaignEmailSenderInterface;
use Mailgun\Connection\Exceptions\MissingEndpoint;
use Mailgun\Mailgun;
use Mailgun\Messages\BatchMessage;
use Zend\Expressive\Template\TemplateRendererInterface;

class CampaignEmailSender implements CampaignEmailSenderInterface
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

    public function setCampaign(Campaign $campaign) : CampaignEmailSender
    {
        $this->campaign = $campaign;
        return $this;
    }

    public function send()
    {
        $this->createMailgunCampaign();
        $batchMessage = $this->getBatchMessage();

        $tags = $this->campaign->getTags()->toArray();
        foreach ($tags as $tag){
            $batchMessage->addTag($tag->getName());
        }

        $customers = $this->repository->findByTags($tags);
        foreach ($customers as $customer){
            $name = $customer->getName() ?? $customer->getEmail();
            $batchMessage->addToRecipient($customer->getEmail(), ['full_name' => $name]);
        }

        $batchMessage->finalize();
    }

    protected function getBatchMessage() : BatchMessage
    {
        $batchMessage = $this->mailgun->BatchMessage($this->mailgunConfig['domain']);
        $batchMessage->addCampaignId("campaign_{$this->campaign->getId()}");
        $batchMessage->setFromAddress($this->auth->getUser()->getEmail(), $this->auth->getUser()->getName());
        $batchMessage->setSubject($this->campaign->getSubject());
        $batchMessage->setHtmlBody($this->getHtmlBody());
        return $batchMessage;
    }

    protected function getHtmlBody():string
    {
        $template = $this->campaign->getTemplate();
        return $this->templateRenderer->render('app::campaign/_template-campaign', [
            'content' => $template
        ]);
    }

    protected function createMailgunCampaign()
    {
        $domain = $this->mailgunConfig['domain'];
        try{
            $this->mailgun->get("$domain/campaigns/campaign_{$this->campaign->getId()}");
        } catch (MissingEndpoint $e) {
            $this->mailgun->post("$domain/campaigns", [
                'id' => "campaign_{$this->campaign->getId()}",
                'name' => $this->campaign->getName()
            ]);
        }
    }
}