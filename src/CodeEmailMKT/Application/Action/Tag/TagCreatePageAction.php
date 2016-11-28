<?php

namespace CodeEmailMKT\Application\Action\Tag;

use CodeEmailMKT\Application\Form\TagForm;
use CodeEmailMKT\Domain\Persistence\TagRepositoryInterface;
use CodeEmailMKT\Domain\Service\FlashMessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template;



class TagCreatePageAction
{

    private $template;

    /**
     * @var TagRepositoryInterface
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
        TagRepositoryInterface $repository,
        Template\TemplateRendererInterface $template,
        RouterInterface $router,
        TagForm $form
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
            //cadastrar tag
            $dataRaw = $request->getParsedBody();
            $this->form->setData($dataRaw);
            if($this->form->isValid()){
                $flashMessage = $request->getAttribute('flashMessage');
                $entity = $this->form->getData();

                try {
                    $this->repository->create($entity);
                    $flashMessage->setMessage(FlashMessageInterface::MESSAGE_SUCCESS, 'Tag cadastrada com sucesso');
                } catch (\Exception $e) {
                    $flashMessage->setMessage('error', $e->getMessage());
                }

                $uri = $this->router->generateUri('tag.list');
                return new RedirectResponse($uri);
            }
        }

        return new HtmlResponse($this->template->render('app::tag/create', [
            'form' => $this->form
        ]));
    }
}
