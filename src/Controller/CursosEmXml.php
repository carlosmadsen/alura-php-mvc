<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Curso;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;

class CursosEmXml implements RequestHandlerInterface
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
		$cursosEmXml = new \SimpleXMLElement('<cursos/>');

		foreach ($cursos as $curso) {
			$cursoEmXml = $cursosEmXml->addChild('curso');
			$cursoEmXml->addChild('id', $curso->getId());
      		$cursoEmXml->addChild('descricao', $curso->getDescricao());
		};

		return new Response(
			200,
			['Content-Type' => 'application/xml'],
			$cursosEmXml->asXML()
		);
	}
}
 