<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Verifica se a aplicação está em modo de manutenção (arquivo gerado pelo comando artisan)
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Registra o autoloader do Composer (carrega dependências do vendor/)
require __DIR__.'/../vendor/autoload.php';

// Bootstrap do Laravel: retorna a instância da aplicação e trata a requisição
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
