<?php

namespace CodeEmailMKT\Application\Action\Customer;

use CodeEmailMKT\Application\Form\CustomerForm;
use CodeEmailMKT\Domain\Entity\Customer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template;
use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;
use Zend\Form\Form;
use Zend\View\HelperPluginManager;

class CustomerCreatePageAction
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


    public function __construct(CustomerRepositoryInterface $repository, Template\TemplateRendererInterface $template, RouterInterface $router)
    {
        $this->repository = $repository;
        $this->template = $template;
        $this->router = $router;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $form = new CustomerForm();

        if($request->getMethod() == 'POST'){
            //cadastrar contato
            $dataRaw = $request->getParsedBody();
            $form->setData($dataRaw);
            if($form->isValid()){
                $flashMessage = $request->getAttribute('flashMessage');
                $entity = $form->getData();
                try {
                    $this->repository->create($entity);
                    $flashMessage->setMessage('success', 'Contato cadastrado com sucesso');
                } catch (\Exception $e) {
                    $flashMessage->setMessage('error', $e->getMessage());
                }

                $uri = $this->router->generateUri('customer.list');
                return new RedirectResponse($uri);
            }
        }

        return new HtmlResponse($this->template->render('app::customer/create', [
            'form' => $form
        ]));
    }
}
