<?php

namespace CodeEmailMKT\Application\Middleware;

use CodeEmailMKT\Domain\Service\BootstrapInterface;
use CodeEmailMKT\Domain\Service\FlashMessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BootstrapMiddleware
{
    /**
     * @var BootstrapInterface
     */
    private $bootstrap;

    /**
     * @var FlashMessageInterface
     */
    private $flashMessage;

    public function __construct(BootstrapInterface $bootstrap, FlashMessageInterface $flashMessage)
    {
        $this->bootstrap = $bootstrap;
        $this->flashMessage = $flashMessage;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $this->bootstrap->create();
        $request = $request->withAttribute('flashMessage', $this->flashMessage);
        $request = $this->spoofingMethod($request);
        return $next($request, $response);
    }

    protected function spoofingMethod(ServerRequestInterface $request)
    {
        $data = $request->getParsedBody();
        $method = isset($data['_method']) ? strtoupper($data['_method']) : '';
        if(in_array($method, ['PUT', 'DELETE'])){
            $request = $request->withMethod($method);
        }
        return $request;
    }
}