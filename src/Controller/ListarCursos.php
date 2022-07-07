<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Infra\EntityManagerCreator;
use Alura\Cursos\Helper\RenderizadorDeHtmlTrait;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;

class ListarCursos  implements RequestHandlerInterface
{
    use RenderizadorDeHtmlTrait;
    private $repositorioDeCursos;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repositorioDeCursos = $this->entityManager->getRepository(Curso::class);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $cursos = $this->repositorioDeCursos->findAll();
        $html = $this->renderizaHtml('cursos/listar-cursos.php', [
            'cursos' => $cursos,
            'titulo' => 'Lista de cursos'
        ]);
        return new Response(200, [], $html);
    }
}