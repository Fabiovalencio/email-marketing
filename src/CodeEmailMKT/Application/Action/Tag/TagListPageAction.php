<?php

namespace CodeEmailMKT\Application\Action\Tag;

use CodeEmailMKT\Domain\Service\FlashMessageInterface;
use CodeEmailMKT\Domain\Persistence\TagRepositoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template;

class TagListPageAction
{

    private $template;

    /**
     * @var TagRepositoryInterface
     */
    private $repository;

    public function __construct(TagRepositoryInterface $repository, Template\TemplateRendererInterface $template = null)
    {
        $this->repository = $repository;
        $this->template = $template;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $tags = $this->repository->findAll();
        $flashMessage = $request->getAttribute('flashMessage');
        return new HtmlResponse($this->template->render('app::tag/list', [
            'tags' => $tags,
            'message' => $flashMessage->getMessage(FlashMessageInterface::MESSAGE_SUCCESS),
            'error' => $flashMessage->getMessage(FlashMessageInterface::MESSAGE_ERROR)
        ]));
    }
}
