<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Arquivo bootstrap — carregamentos adicionais podem ser feitos aqui
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Configurações de exceções podem ser registradas aqui
    })->create();
