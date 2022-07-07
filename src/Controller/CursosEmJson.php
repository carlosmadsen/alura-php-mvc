<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Curso;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;

class CursosEmJson implements RequestHandlerInterface
{
	private $entityManager;
  	private $repositorioDeCursos;

	public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
		$this->repositorioDeCursos = $this->entityManager->getRepository(Curso::class);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
		$cursos = $this->repositorioDeCursos->findAll();
    	return new Response( 200, ['Content-Type' => 'application/json'], json_encode($cursos));
	}
}
 