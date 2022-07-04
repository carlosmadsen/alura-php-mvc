<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Infra\EntityManagerCreator;
use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Helper\FlashMessageTrait;

class Persistencia implements InterfaceControladorRequisicao {
  use FlashMessageTrait;

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $entityManager;

    public function __construct()
    {
        $this->entityManager = (new EntityManagerCreator())->getEntityManager();
    }

    public function processaRequisicao(): void
    {      
      try { 
        $descricao = filter_input(
          INPUT_POST,
          'descricao',
          FILTER_SANITIZE_STRING);

        $id = filter_input(
          INPUT_GET,
          'id',
          FILTER_VALIDATE_INT);

        $curso = new Curso();
        $curso->setDescricao($descricao);
        //alterar 
        if (!is_null($id) && $id !== false) {
            $curso->setId($id);
            $this->entityManager->merge($curso);
            $this->defineMensagem('success', 'Curso alterado com sucesso.');	
        } else { //inserir 
            $this->entityManager->persist($curso);
            $this->defineMensagem('success', 'Curso inserido com sucesso.');	
        }
        $this->entityManager->flush();
      }
      catch (\Exception $e) {
        $this->defineMensagem('danger', $e->getMessage());	
      }
      header('Location: /listar-cursos', true, 302);
    }
}