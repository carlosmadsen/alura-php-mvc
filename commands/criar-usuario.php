<?php

require __DIR__ . '/../vendor/autoload.php';

use Alura\Cursos\Entity\Usuario;
use Alura\Cursos\Infra\EntityManagerCreator;

try {
	$email = $argv[1];
	if (empty($email)) {
		throw new Exception("E-mail não informado.", 1);
	}
	$senha = $argv[2];
	if (empty($senha)) {
		throw new Exception("Senha não informada.", 1);
	}

	$entityManagerCreator  = new EntityManagerCreator();
	$entityManager = $entityManagerCreator->getEntityManager();
		
	$usuario = new Usuario();
	$usuario->setEmail($email);
	$usuario->setSenha($senha);
	$entityManager->persist($usuario);
	$entityManager->flush();

	echo "Usuário criado com sucesso.\n\n";
}
catch (\Exception $e) {
	echo $e->getMessage()."\n";
}
