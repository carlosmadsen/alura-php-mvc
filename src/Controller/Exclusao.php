<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Helper\FlashMessageTrait;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;

class Exclusao implements RequestHandlerInterface
{
	use FlashMessageTrait;
	private $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
		try {			
			$id = filter_var($request->getQueryParams()['id'], FILTER_VALIDATE_INT);
			if (is_null($id) || $id === false) {
				throw new \Exception("Id de curso inválido.", 1);
			}

			$curso = $this->entityManager->getReference(Curso::class, $id);
			$this->entityManager->remove($curso);
			$this->entityManager->flush();
			$this->defineMensagem('success', 'Curso removido com sucesso');
		}
		catch (\Exception $e) {
			$this->defineMensagem('danger', $e->getMessage());
		}
		return new Response(302, ['Location' => '/listar-cursos'], null);
    }
}