<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Usuario;
use Alura\Cursos\Infra\EntityManagerCreator;
use Alura\Cursos\Helper\FlashMessageTrait;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;

class RealizarLogin implements RequestHandlerInterface
{
	 use FlashMessageTrait;

    private $repositorioUsuarios;
	private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
		$this->entityManager = $entityManager;
        $this->repositorioUsuarios = $this->entityManager->getRepository(Usuario::class);
    }

	public function handle(ServerRequestInterface $request): ResponseInterface
	{
		try {
			$email = filter_var($request->getParsedBody()['email'], FILTER_VALIDATE_EMAIL);
			$senha = filter_var($request->getParsedBody()['senha'], FILTER_SANITIZE_STRING);
		
			if (is_null($email) || $email === false) {
				throw new \Exception("E-mail ou senha inválido.", 1);		
			}

			$usuario = $this->repositorioUsuarios->findOneBy(['email' => $email]);
			if (is_null($usuario) or !$usuario->senhaEstaCorreta($senha)) {
				throw new \Exception("E-mail ou senha inválido.", 1);				
			}

			$_SESSION['logado'] = true;
			return new Response(302, ['Location' => '/listar-cursos'], null);
		}
		catch (\Exception $e) {
       		$this->defineMensagem('danger', $e->getMessage());
			return new Response(302, ['Location' => '/login'], null);
     	}
	} 
}