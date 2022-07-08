<?php

require __DIR__ . '/../vendor/autoload.php';

use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Infra\EntityManagerCreator;

try {
	$entityManagerCreator  = new EntityManagerCreator();
	$entityManager = $entityManagerCreator->getEntityManager();

	$descricoesCursos = [
		'Agroecologia',
		'Artes Visuais - Licenciatura',
		'Ciências Econômicas',
		'Direito',
		'Engenharia de Automação',
		'Engenharia Química',
		'Física - Licenciatura',
		'Matemática',
		'Pedagogia',
		'Psicologia',
		'Relações Internacionais',
		'Sistemas de Informação'
	];

	foreach ($descricoesCursos as $descricao) {
		$curso = new Curso();
		$curso->setDescricao($descricao);
		$entityManager->persist($curso);
		$entityManager->flush();
	}

	echo "Cursos criados com sucesso.\n\n";
}
catch (\Exception $e) {
	echo $e->getMessage()."\n";
}
