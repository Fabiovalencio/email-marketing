<?php

namespace CodeEmailMKT\Application\Action\Campaign;

use CodeEmailMKT\Application\Form\CampaignForm;
use CodeEmailMKT\Application\Form\HttpMethodelement;
use CodeEmailMKT\Domain\Service\CampaignEmailSenderInterface;
use CodeEmailMKT\Domain\Service\FlashMessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template;
use CodeEmailMKT\Domain\Persistence\CampaignRepositoryInterface;

class CampaignSenderPageAction
{

    private $template;

    /**
     * @var CampaignRepositoryInterface
     */
    private $repository;

    /**
     * @var $router
     */
    private $router;

    /**
     * @var $form
     */
    private $form;

    /**
     * @var CampaignEmailSenderInterface
     */
    private $emaiSender;

    public function __construct(
        CampaignRepositoryInterface $repository,
        Template\TemplateRendererInterface $template = null,
        RouterInterface $router,
        CampaignForm $form,
        CampaignEmailSenderInterface $emaiSender
    )
    {
        $this->repository = $repository;
        $this->template = $template;
        $this->router = $router;
        $this->form = $form;
        $this->emaiSender = $emaiSender;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $id = $request->getAttribute('id');
        $entity = $this->repository->find($id);
        $this->form->bind($entity);

        if($request->getMethod() == 'POST'){
            $flashMessage = $request->getAttribute('flashMessage');
            $this->emaiSender->setCampaign($entity);
            try {
                $this->emaiSender->send();
                $flashMessage->setMessage(FlashMessageInterface::MESSAGE_SUCCESS, 'Campanha enviada com sucesso');
            } catch (\Exception $e) {
                if($e->getMessage() == 'An HTTP Error has occurred! Check your network connection and try again.'){
                    $flashMessage->setMessage(FlashMessageInterface::MESSAGE_ERROR, "Você só pode enviar e-mails para uma campanha.");
                } else {
                    $flashMessage->setMessage(FlashMessageInterface::MESSAGE_ERROR, $e->getMessage());
                }
            }

            $uri = $this->router->generateUri('campaign.list');
            return new RedirectResponse($uri);
        }

        return new HtmlResponse($this->template->render('app::campaign/sender', [
            'form' => $this->form
        ]));
    }
}
