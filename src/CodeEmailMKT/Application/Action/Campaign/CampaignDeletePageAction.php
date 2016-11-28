<?php

namespace CodeEmailMKT\Application\Action\Campaign;

use CodeEmailMKT\Application\Form\CampaignForm;
use CodeEmailMKT\Application\Form\HttpMethodelement;
use CodeEmailMKT\Domain\Service\CampaignDeleteInterface;
use CodeEmailMKT\Domain\Service\FlashMessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template;
use CodeEmailMKT\Domain\Persistence\CampaignRepositoryInterface;

class CampaignDeletePageAction
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
     * @var $emailDelete
     */
    private $emailDelete;

    public function __construct(
        CampaignRepositoryInterface $repository,
        Template\TemplateRendererInterface $template = null,
        RouterInterface $router,
        CampaignForm $form,
        CampaignDeleteInterface $emailDelete
    )
    {
        $this->repository = $repository;
        $this->template = $template;
        $this->router = $router;
        $this->form = $form;
        $this->emailDelete = $emailDelete;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $id = $request->getAttribute('id');
        $entity = $this->repository->find($id);

        $this->form->bind($entity);

        if($request->getMethod() == 'DELETE'){

            $flashMessage = $request->getAttribute('flashMessage');
            $this->emailDelete->setCampaign($entity);
            try {
                $this->emailDelete->deleteCampaign();
                $flashMessage->setMessage(FlashMessageInterface::MESSAGE_SUCCESS, 'Campanha excluída com sucesso');
            } catch (\Exception $e) {
                if($e->getMessage() == 'An HTTP Error has occurred! Check your network connection and try again.'){
                    $flashMessage->setMessage(FlashMessageInterface::MESSAGE_ERROR, "Erro ao tentar excluir a campanha.");
                } else {
                    $flashMessage->setMessage(FlashMessageInterface::MESSAGE_ERROR, $e->getMessage());
                }
            }

            return true;
        }

    }
}
