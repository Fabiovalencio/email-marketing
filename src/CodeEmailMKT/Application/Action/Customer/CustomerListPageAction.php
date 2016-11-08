<?php

namespace CodeEmailMKT\Application\Action\Customer;

use CodeEmailMKT\Domain\Entity\Customer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template;
use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;

class CustomerListPageAction
{

    private $template;

    /**
     * @var CustomerRepositoryInterface
     */
    private $repository;

    public function __construct(CustomerRepositoryInterface $repository, Template\TemplateRendererInterface $template = null)
    {
        $this->repository = $repository;
        $this->template = $template;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $customers = $this->repository->findAll();
        $flashMessage = $request->getAttribute('flashMessage');
        return new HtmlResponse($this->template->render('app::customer/list', [
            'customers' => $customers,
            'message' => $flashMessage->getMessage('success'),
            'error' => $flashMessage->getMessage('error')
        ]));
    }
}
