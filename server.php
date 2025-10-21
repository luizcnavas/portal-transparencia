<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * Este arquivo roteia requisições para o servidor embutido do PHP.
 * Serve arquivos estáticos diretamente e roteia outras requisições para index.php
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

// Serve arquivos estáticos da pasta public diretamente
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

// Roteia todas as outras requisições para o front controller
require_once __DIR__.'/public/index.php';
