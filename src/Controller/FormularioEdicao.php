<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Infra\EntityManagerCreator;
use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Helper\RenderizadorDeHtmlTrait;
use Alura\Cursos\Helper\FlashMessageTrait;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;

class FormularioEdicao implements RequestHandlerInterface
{
	use RenderizadorDeHtmlTrait;
	use FlashMessageTrait;

	private $repositorioCursos;
	private $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
		$this->repositorioCursos = $this->entityManager->getRepository(Curso::class);
	}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
		try {
			$id = filter_var($request->getQueryParams()['id'], FILTER_VALIDATE_INT);
			if (is_null($id) || $id === false) {
				throw new \Exception("Id de curso inválido.", 1);
			}

			$curso = $this->repositorioCursos->find($id);
			if (is_null($curso)) {
				throw new \Exception("Não foi possível identificar o curso.", 1);
			}

			$html = $this->renderizaHtml('cursos/formulario.php', [
				'titulo' => 'Alterar curso ' . $curso->getDescricao(),
				'curso' => $curso,
				'id' => $id
			]);
			return new Response(200, [], $html);
		}
		catch (\Exception $e) {
			$this->defineMensagem('danger', $e->getMessage());
			return new Response(302, ['Location' => '/listar-cursos'], null);
		}
    }
}