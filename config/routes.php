<?php

use Alura\Cursos\Controller\{
    FormularioInsercao,
    ListarCursos,
    Persistencia,
    Exclusao,
    FormularioEdicao
};

$rotas = [
    '/listar-cursos' => ListarCursos::class,
    '/novo-curso' => FormularioInsercao::class,
    '/salvar-curso' => Persistencia::class,
    '/excluir-curso' => Exclusao::class,
    '/alterar-curso' => FormularioEdicao::class
];

return $rotas;