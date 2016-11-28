<?php

namespace CodeEmailMKT\Application\Action\Campaign;

use CodeEmailMKT\Application\Form\CampaignForm;
use CodeEmailMKT\Application\Form\HttpMethodelement;
use CodeEmailMKT\Domain\Service\FlashMessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template;
use CodeEmailMKT\Domain\Persistence\CampaignRepositoryInterface;

class CampaignUpdatePageAction
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
        Template\TemplateRendererInterface $template = null,
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
        $id = $request->getAttribute('id');
        $entity = $this->repository->find($id);

        $this->form->add(new HttpMethodelement('PUT'));
        $this->form->bind($entity);

        if($request->getMethod() == 'PUT'){
            $flashMessage = $request->getAttribute('flashMessage');
            $dataRaw = $request->getParsedBody();
            $this->form->setData($dataRaw);

            if($this->form->isValid()){
                $entity = $this->form->getData();
                try {
                    $this->repository->update($entity);
                    $flashMessage->setMessage(FlashMessageInterface::MESSAGE_SUCCESS, 'Dados da campanha alterados com sucesso');
                } catch (\Exception $e) {
                    $flashMessage->setMessage(FlashMessageInterface::MESSAGE_ERROR, $e->getMessage());
                }

                $uri = $this->router->generateUri('campaign.list');
                return new RedirectResponse($uri);
            }
        }

        return new HtmlResponse($this->template->render('app::campaign/update', [
            'form' => $this->form
        ]));
    }
}
