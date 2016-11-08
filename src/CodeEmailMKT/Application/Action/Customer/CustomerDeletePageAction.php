<?php

namespace CodeEmailMKT\Application\Action\Customer;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template;
use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;

class CustomerDeletePageAction
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

    public function __construct(CustomerRepositoryInterface $repository, Template\TemplateRendererInterface $template = null, RouterInterface $router)
    {
        $this->repository = $repository;
        $this->template = $template;
        $this->router = $router;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $id = $request->getAttribute('id');
        $entity = $this->repository->find($id);

        if($request->getMethod() == 'GET'){
            $flashMessage = $request->getAttribute('flashMessage');

            try {
                $this->repository->remove($entity);
                $flashMessage->setMessage('success', 'Contato excluído com sucesso');
            } catch (\Exception $e) {
                $flashMessage->setMessage('error', $e->getMessage());
            }

            $uri = $this->router->generateUri('customer.list');
            return new RedirectResponse($uri);
        }

    }
}
