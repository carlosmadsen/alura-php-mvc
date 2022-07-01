<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Usuario;
use Alura\Cursos\Infra\EntityManagerCreator;

class RealizarLogin implements InterfaceControladorRequisicao
{
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
		$email = filter_input(INPUT_POST,
			'email',
			FILTER_VALIDATE_EMAIL
		);

		$senha = filter_input(INPUT_POST,
        	'senha',
        	FILTER_SANITIZE_STRING
		);

		if (is_null($email) || $email === false) {
			echo "E-mail inváido";
			return;
		}

		$usuario = $this->repositorioUsuarios->findOneBy(['email' => $email]);
		if (is_null($usuario) or !$usuario->senhaEstaCorreta($senha)) {
			echo "E-mail ou senha inválido.";
			return;
		}

		$_SESSION['logado'] = true;

		header('Location: /listar-cursos');
	}
}