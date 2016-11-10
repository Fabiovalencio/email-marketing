<?php

namespace CodeEmailMKT\Application\Action\Customer;

use CodeEmailMKT\Application\Form\CustomerForm;
use CodeEmailMKT\Application\Form\HttpMethodelement;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template;
use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;

class CustomerUpdatePageAction
{

    private $template;

    /**
     * @var CustomerRepositoryInterface
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
        CustomerRepositoryInterface $repository,
        Template\TemplateRendererInterface $template = null,
        RouterInterface $router,
        CustomerForm $form
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
            $dataRaw = $request->getParsedBody();
            $this->form->setData($dataRaw);
            if($this->form->isValid()){
                $flashMessage = $request->getAttribute('flashMessage');
                $entity = $this->form->getData();

                try {
                    $this->repository->update($entity);
                    $flashMessage->setMessage('success', 'Dados do contato alterados com sucesso');
                } catch (\Exception $e) {
                    $flashMessage->setMessage('error', $e->getMessage());
                }

                $uri = $this->router->generateUri('customer.list');
                return new RedirectResponse($uri);
            }
        }

        return new HtmlResponse($this->template->render('app::customer/update', [
            'form' => $this->form
        ]));
    }
}
