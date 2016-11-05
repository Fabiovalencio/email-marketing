<?php

namespace CodeEmailMKT\Action;

use CodeEmailMKT\Entity\Category;
use CodeEmailMKT\Entity\Cliente;
use CodeEmailMKT\Entity\Endereco;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Expressive\Plates\PlatesRenderer;
use Zend\Expressive\Twig\TwigRenderer;
use Zend\Expressive\ZendView\ZendViewRenderer;

class TestePageAction
{
    private $manager;
    private $router;
    private $template;

    public function __construct(EntityManager $manager, Router\RouterInterface $router, Template\TemplateRendererInterface $template = null)
    {
        $this->manager = $manager;
        $this->router   = $router;
        $this->template = $template;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        //Cliente A
        $clienteA = new Cliente();
        $enderecoA = new Endereco();
        $clienteA->setNome('cliente A');
        $clienteA->setCpf('1234567890');
        $clienteA->setEmail('clientea@cliente.com');
        //Persiste dados do cliente B
        $this->manager->persist($clienteA);
        //Grava dados no BD
        $this->manager->flush();

        $enderecoA->setIdCliente($clienteA->getId());
        $enderecoA->setCep('01010000');
        $enderecoA->setLogradouro('rua do cliente A, 1000');
        $enderecoA->setCidade('Cidade do cliente A');
        $enderecoA->setEstado('Estado do cliente A');
        //Persiste endereco do cliente A
        $this->manager->persist($enderecoA);
        //Grava dados no BD
        $this->manager->flush();

        //Cliente B
        $clienteB = new Cliente();
        $enderecoB = new Endereco();
        $clienteB->setNome('cliente B');
        $clienteB->setCpf('1234567891');
        $clienteB->setEmail('clienteb@cliente.com');
        //Persiste dados do cliente B
        $this->manager->persist($clienteB);
        //Grava dados no BD
        $this->manager->flush();

        $enderecoB->setIdCliente($clienteB->getId());
        $enderecoB->setCep('11010000');
        $enderecoB->setLogradouro('rua do cliente B, 1100');
        $enderecoB->setCidade('Cidade do cliente B');
        $enderecoB->setEstado('Estado do cliente B');
        //Persiste endereco do cliente B
        $this->manager->persist($enderecoB);
        //Grava dados no BD
        $this->manager->flush();

        //Cliente C
        $clienteC = new Cliente();
        $enderecoC1 = new Endereco();
        $enderecoC2 = new Endereco();

        $clienteC->setNome('cliente C');
        $clienteC->setCpf('1234567892');
        $clienteC->setEmail('clientec@cliente.com');
        //Persiste dados do cliente C
        $this->manager->persist($clienteC);
        //Grava dados no BD
        $this->manager->flush();

        $enderecoC1->setIdCliente($clienteC->getId());
        $enderecoC1->setCep('21010000');
        $enderecoC1->setLogradouro('endereço 1 do cliente C, 1200');
        $enderecoC1->setCidade('Cidade 1 do cliente C');
        $enderecoC1->setEstado('Estado 1 do cliente C');
        $enderecoC2->setIdCliente($clienteC->getId());
        $enderecoC2->setCep('31010000');
        $enderecoC2->setLogradouro('endereço 2 do cliente C, 1300');
        $enderecoC2->setCidade('Cidade 2 do cliente C');
        $enderecoC2->setEstado('Estado 2 do cliente C');
        //Persiste endereco do cliente A
        $this->manager->persist($enderecoC1);
        $this->manager->persist($enderecoC2);
        //Grava dados no BD
        $this->manager->flush();

        //recupera dados gravados no BD
        $arrayClientes = [];
        $x = 0;
        $clientes = $this->manager->getRepository(Cliente::class)->findAll();

        foreach ($clientes as $cliente) {
            $arrayClientes[$x] = $cliente;
            $endereco = $this->manager->getRepository(Endereco::class)->findBy(array('id' => $cliente->getId()));
            $arrayClientes[$x]->endereco = $endereco;
            $x++;
        }

        $data['message'] = 'Dados dos Clientes.';

        return new HtmlResponse($this->template->render('app::teste-page', [
            'data' => $data,
            'clientes' => $arrayClientes
        ]));
    }
}
