<?php

namespace CodeEmailMKT\Application\Action\Campaign;

use CodeEmailMKT\Domain\Entity\Campaign;
use CodeEmailMKT\Domain\Service\FlashMessageInterface;
use CodeEmailMKT\Infrastructure\Service\FlashMessage;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template;
use CodeEmailMKT\Domain\Persistence\CampaignRepositoryInterface;

class CampaignListPageAction
{

    private $template;

    /**
     * @var CampaignRepositoryInterface
     */
    private $repository;

    public function __construct(CampaignRepositoryInterface $repository, Template\TemplateRendererInterface $template = null)
    {
        $this->repository = $repository;
        $this->template = $template;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $campaigns = $this->repository->findAll();
        /**
         * @var FlashMessageInterface $flashMessage
         */
        $flashMessage = $request->getAttribute('flashMessage');
        return new HtmlResponse($this->template->render('app::campaign/list', [
            'campaigns' => $campaigns,
            'message' => $flashMessage->getMessage(FlashMessageInterface::MESSAGE_SUCCESS) ?? $flashMessage->getMessage(FlashMessageInterface::MESSAGE_ERROR),
            'messageType' =>  $flashMessage->getMessage(FlashMessageInterface::MESSAGE_SUCCESS) ? 'success' : 'error'
        ]));
    }
}
