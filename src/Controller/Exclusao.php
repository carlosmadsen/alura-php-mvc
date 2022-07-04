<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Infra\EntityManagerCreator;
use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Helper\FlashMessageTrait;

class Exclusao implements InterfaceControladorRequisicao
{
	use FlashMessageTrait;

	private $entityManager;

	public function __construct()
    {
        $this->entityManager = (new EntityManagerCreator())
            ->getEntityManager();
    }

    public function processaRequisicao(): void
    {
		try {			
			$id = filter_input(INPUT_GET,
				'id',
				FILTER_VALIDATE_INT);

			if (is_null($id) || $id === false) {
				throw new \Exception("Id curso inválido.", 1);
			}

			$curso = $this->entityManager->getReference(Curso::class, $id);
			$this->entityManager->remove($curso);
			$this->entityManager->flush();
			$this->defineMensagem('success', 'Curso removido com sucesso');			
		}
		catch (\Exception $e) {
			$this->defineMensagem('danger', $e->getMessage());	
		}
		header('Location: /listar-cursos');
    }
}