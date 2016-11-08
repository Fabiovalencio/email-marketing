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

        if($request->getMethod() == 'POST'){
            $flashMessage = $request->getAttribute('flashMessage');
            $data = $request->getParsedBody();

            $entity
                ->setName($data['name'])
                ->setEmail($data['email']);

            try {
                $this->repository->update($entity);
                $flashMessage->setMessage('success', 'Dados do contato alterados com sucesso');
            } catch (\Exception $e) {
                $flashMessage->setMessage('error', $e->getMessage());
            }

            $uri = $this->router->generateUri('customer.list');

            return new RedirectResponse($uri);
        }

        return new HtmlResponse($this->template->render('app::customer/update', [
            'customer' => $entity
        ]));
    }
}
