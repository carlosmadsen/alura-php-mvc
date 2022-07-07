<?php

use Alura\Cursos\Controller\{
    FormularioInsercao,
    ListarCursos,
    Persistencia,
    Exclusao,
    FormularioEdicao,
    FormularioLogin,
    RealizarLogin,
    Deslogar,
    CursosEmJson,
    CursosEmXml 
};

$rotas = [
    '/listar-cursos' => ListarCursos::class,
    '/novo-curso' => FormularioInsercao::class,
    '/salvar-curso' => Persistencia::class,
    '/excluir-curso' => Exclusao::class,
    '/alterar-curso' => FormularioEdicao::class,
    '/login' => FormularioLogin::class,
    '/realiza-login' => RealizarLogin::class,
    '/logout' => Deslogar::class,
    '/buscarCursosEmJson' => CursosEmJson::class,
    '/buscarCursosEmXml' => CursosEmXml::class
];

return $rotas;