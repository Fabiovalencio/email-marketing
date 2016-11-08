<?php

namespace CodeEmailMKT\Application\Action;

use CodeEmailMKT\Domain\Entity\Customer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;

class TestePageAction
{
    private $manager;
    private $router;
    private $template;

    /**
     * @var CustomerRepositoryInterface
     */
    private $repository;

    public function __construct(CustomerRepositoryInterface $repository, Router\RouterInterface $router, Template\TemplateRendererInterface $template = null)
    {
        $this->repository = $repository;
        $this->router   = $router;
        $this->template = $template;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $customerEmail = $this->repository->findByEmail('fabiovalencio2@hotmail.com');

        if(!$customerEmail){
            $customer = new Customer();
            $customer->setName('Fabio')
                ->setEmail('fabiovalencio2@hotmail.com');

            $this->repository->create($customer);
        }

        $customers = $this->repository->findAll();
        $data['message'] = 'Dados de contatos.';

        return new HtmlResponse($this->template->render('app::teste-page', [
            'data' => $data,
            'customers' => $customers
        ]));
    }
}
