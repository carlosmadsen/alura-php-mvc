<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Usuario;
use Alura\Cursos\Infra\EntityManagerCreator;
use Alura\Cursos\Helper\FlashMessageTrait;

class RealizarLogin implements InterfaceControladorRequisicao
{
	 use FlashMessageTrait;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $repositorioUsuarios;

    public function __construct()
    {
		$entityManager = (new EntityManagerCreator())
            ->getEntityManager();
        $this->repositorioUsuarios = $entityManager
            ->getRepository(Usuario::class);
    }

	public function processaRequisicao(): void
	{
		try {
			$email = filter_input(INPUT_POST,
				'email',
				FILTER_VALIDATE_EMAIL
			);

			$senha = filter_input(INPUT_POST,
				'senha',
				FILTER_SANITIZE_STRING
			);

			if (is_null($email) || $email === false) {
				throw new \Exception("E-mail ou senha inválido.", 1);		
			}

			$usuario = $this->repositorioUsuarios->findOneBy(['email' => $email]);
			if (is_null($usuario) or !$usuario->senhaEstaCorreta($senha)) {
				throw new \Exception("E-mail ou senha inválido.", 1);				
			}

			$_SESSION['logado'] = true;
			header('Location: /listar-cursos');
		}
		catch (\Exception $e) {
       		$this->defineMensagem('danger', $e->getMessage());
			header('Location: /login');
     	}

	}
}