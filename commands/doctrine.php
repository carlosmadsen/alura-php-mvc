<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Alura\Cursos\Infra\EntityManagerCreator;

require_once __DIR__ . '/../vendor/autoload.php';

$entityManagerCreator  = new EntityManagerCreator();
$entityManager = $entityManagerCreator->getEntityManager();

ConsoleRunner::run(
	new SingleManagerProvider($entityManager)
);
