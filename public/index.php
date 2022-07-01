<?php

require __DIR__ . '/../vendor/autoload.php';

$caminho = $_SERVER['PATH_INFO'];
$rotas = require __DIR__ . '/../config/routes.php';

if (!array_key_exists($caminho, $rotas)) {
    http_response_code(404);
    exit();
}

session_start();

$ehRotaLogin = stripos($caminho, 'login');
if (!isset($_SESSION['logado']) and ($ehRotaLogin === false)) {
    header('Location: /login');
    exit();
}

$classeControladora = $rotas[$caminho];
$controlador = new $classeControladora();
$controlador->processaRequisicao();
