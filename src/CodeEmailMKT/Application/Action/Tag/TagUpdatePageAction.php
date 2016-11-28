<?php

namespace CodeEmailMKT\Application\Action\Tag;

use CodeEmailMKT\Application\Form\TagForm;
use CodeEmailMKT\Application\Form\HttpMethodelement;
use CodeEmailMKT\Domain\Service\FlashMessageInterface;
use CodeEmailMKT\Domain\Persistence\TagRepositoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template;

class TagUpdatePageAction
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
        Template\TemplateRendererInterface $template = null,
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
                    $flashMessage->setMessage(FlashMessageInterface::MESSAGE_SUCCESS, 'Dados do contato alterados com sucesso');
                } catch (\Exception $e) {
                    var_dump($e);
                    $flashMessage->setMessage(FlashMessageInterface::MESSAGE_ERROR, $e->getMessage());
                }

                $uri = $this->router->generateUri('tag.list');
                return new RedirectResponse($uri);
            }
        }

        return new HtmlResponse($this->template->render('app::tag/update', [
            'form' => $this->form
        ]));
    }
}
