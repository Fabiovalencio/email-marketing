<?php

namespace CodeEmailMKT\Application\Action\Customer;

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
        $myForm = new Form();
        $myForm->add([
            'name' => 'name',
            'type' => 'Text',
            'options' => [
                'label' => 'Nome'
            ]
        ]);

        $myForm->add([
            'name' => 'email',
            'type' => 'Text',
            'options' => [
                'label' => 'E-mail'
            ]
        ]);

        $myForm->add([
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => [
                'value' => 'Enviar'
            ]
        ]);


        if($request->getMethod() == 'POST'){
            //cadastrar contato
            $data = $request->getParsedBody();
            $entity = new Customer();
            $entity
                ->setName($data['name'])
                ->setEmail($data['email']);
            $this->repository->create($entity);

            $flashMessage = $request->getAttribute('flashMessage');
            $uri = $this->router->generateUri('customer.list');
            $flashMessage->setMessage('success', 'Contato cadastrado com sucesso');

            return new RedirectResponse($uri);
        }

        return new HtmlResponse($this->template->render('app::customer/create', [
            'myForm' => $myForm
        ]));
    }
}
