<?php

namespace CodeEmailMKT\Application\Action\Campaign;

use CodeEmailMKT\Application\Form\CampaignForm;
use CodeEmailMKT\Domain\Service\FlashMessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template;
use CodeEmailMKT\Domain\Persistence\CampaignRepositoryInterface;


class CampaignCreatePageAction
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


    public function __construct(
        CampaignRepositoryInterface $repository,
        Template\TemplateRendererInterface $template,
        RouterInterface $router,
        CampaignForm $form
    )
    {
        $this->repository = $repository;
        $this->template = $template;
        $this->router = $router;
        $this->form = $form;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        if($request->getMethod() == 'POST'){
            $dataRaw = $request->getParsedBody();
            $this->form->setData($dataRaw);
            if($this->form->isValid()){
                $flashMessage = $request->getAttribute('flashMessage');
                $entity = $this->form->getData();

                try {
                    $this->repository->create($entity);
                    $flashMessage->setMessage(FlashMessageInterface::MESSAGE_SUCCESS, 'Campanha cadastrada com sucesso');
                } catch (\Exception $e) {
                    $flashMessage->setMessage('error', $e->getMessage());
                }

                $uri = $this->router->generateUri('campaign.list');
                return new RedirectResponse($uri);
            }
        }

        return new HtmlResponse($this->template->render('app::campaign/create', [
            'form' => $this->form
        ]));
    }
}
