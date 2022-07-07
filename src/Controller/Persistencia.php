<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Infra\EntityManagerCreator;
use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Helper\FlashMessageTrait;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;

class Persistencia implements RequestHandlerInterface {
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
        $descricao = filter_var($request->getParsedBody()['descricao'], FILTER_SANITIZE_STRING);

        if (empty($descricao)) {
          throw new \Exception("Descri��o n�o informada.", 1);
        }
        
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
      return new Response(302, ['Location' => '/listar-cursos'], null);
    }
}