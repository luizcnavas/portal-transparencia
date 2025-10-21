#!/usr/bin/env php
<?php

/**
 * Script de Verificação do Ambiente
 * 
 * Este script verifica se o ambiente está configurado corretamente
 * para funcionar em produção (Koyeb, Heroku, etc)
 */

$checks = [];

echo "\n🔍 Verificando configuração do ambiente...\n\n";

// 1. Verifica se .env existe
$checks['env_file'] = file_exists(__DIR__ . '/.env');
echo ($checks['env_file'] ? '✅' : '❌') . " Arquivo .env existe\n";

if ($checks['env_file']) {
    // Carrega .env (formato Laravel)
    $envContent = file_get_contents(__DIR__ . '/.env');
    $env = [];
    foreach (explode("\n", $envContent) as $line) {
        $line = trim($line);
        if (empty($line) || str_starts_with($line, '#')) continue;
        if (str_contains($line, '=')) {
            [$key, $value] = explode('=', $line, 2);
            $env[trim($key)] = trim($value);
        }
    }
    
    // 2. Verifica APP_KEY
    $checks['app_key'] = !empty($env['APP_KEY'] ?? '');
    echo ($checks['app_key'] ? '✅' : '❌') . " APP_KEY está definida\n";
    
    // 3. Verifica APP_URL
    $checks['app_url'] = !empty($env['APP_URL'] ?? '');
    echo ($checks['app_url'] ? '✅' : '❌') . " APP_URL está definida\n";
    
    if ($checks['app_url']) {
        $isHttps = str_starts_with($env['APP_URL'], 'https://');
        echo "   ℹ️  APP_URL: " . $env['APP_URL'] . ($isHttps ? ' (HTTPS ✅)' : ' (HTTP ⚠️)') . "\n";
    }
    
    // 4. Verifica SESSION_DRIVER
    $checks['session_driver'] = !empty($env['SESSION_DRIVER'] ?? '');
    echo ($checks['session_driver'] ? '✅' : '❌') . " SESSION_DRIVER está definida\n";
    
    if ($checks['session_driver']) {
        echo "   ℹ️  SESSION_DRIVER: " . ($env['SESSION_DRIVER'] ?? 'não definido') . "\n";
    }
    
    // 5. Verifica DB_CONNECTION
    $checks['db_connection'] = !empty($env['DB_CONNECTION'] ?? '');
    echo ($checks['db_connection'] ? '✅' : '❌') . " DB_CONNECTION está definida\n";
    
    if ($checks['db_connection']) {
        echo "   ℹ️  DB_CONNECTION: " . ($env['DB_CONNECTION'] ?? 'não definido') . "\n";
        
        // Se for SQLite, verifica se o arquivo existe
        if (($env['DB_CONNECTION'] ?? '') === 'sqlite') {
            $dbPath = $env['DB_DATABASE'] ?? 'database/database.sqlite';
            $dbPath = str_replace('/app/', __DIR__ . '/', $dbPath);
            $dbPath = str_replace('database/', __DIR__ . '/database/', $dbPath);
            
            $dbExists = file_exists($dbPath);
            $checks['db_file'] = $dbExists;
            echo ($dbExists ? '   ✅' : '   ❌') . " Arquivo SQLite existe: $dbPath\n";
        }
    }
    
    // 6. Verifica configurações de produção
    $appEnv = $env['APP_ENV'] ?? 'local';
    echo "\n📊 Ambiente: " . strtoupper($appEnv) . "\n";
    
    if ($appEnv === 'production') {
        echo "\n🚀 Verificações para PRODUÇÃO:\n";
        
        // APP_DEBUG deve ser false
        $debugOff = ($env['APP_DEBUG'] ?? 'true') === 'false';
        echo ($debugOff ? '✅' : '❌') . " APP_DEBUG=false (atual: " . ($env['APP_DEBUG'] ?? 'não definido') . ")\n";
        
        // SESSION_SECURE_COOKIE deve ser true para HTTPS
        if (str_starts_with($env['APP_URL'] ?? '', 'https://')) {
            $secureSession = ($env['SESSION_SECURE_COOKIE'] ?? 'false') === 'true';
            echo ($secureSession ? '✅' : '⚠️') . " SESSION_SECURE_COOKIE=true para HTTPS (atual: " . ($env['SESSION_SECURE_COOKIE'] ?? 'não definido') . ")\n";
        }
    }
}

// 7. Verifica se o middleware TrustProxies existe
$trustProxiesExists = file_exists(__DIR__ . '/app/Http/Middleware/TrustProxies.php');
$checks['trust_proxies'] = $trustProxiesExists;
echo "\n" . ($trustProxiesExists ? '✅' : '❌') . " Middleware TrustProxies existe\n";

// 8. Verifica se bootstrap/app.php registra TrustProxies
$bootstrapContent = file_get_contents(__DIR__ . '/bootstrap/app.php');
$trustProxiesRegistered = str_contains($bootstrapContent, 'trustProxies');
$checks['trust_proxies_registered'] = $trustProxiesRegistered;
echo ($trustProxiesRegistered ? '✅' : '❌') . " TrustProxies registrado no bootstrap\n";

// Resumo final
echo "\n" . str_repeat('=', 50) . "\n";

$totalChecks = count($checks);
$passedChecks = count(array_filter($checks));
$percentage = round(($passedChecks / $totalChecks) * 100);

echo "📊 Resultado: $passedChecks/$totalChecks verificações passaram ($percentage%)\n";

if ($percentage === 100) {
    echo "🎉 Configuração perfeita! Pronto para produção.\n";
} elseif ($percentage >= 80) {
    echo "⚠️  Quase lá! Verifique os itens marcados com ❌\n";
} else {
    echo "❌ Várias configurações precisam ser ajustadas.\n";
    echo "📖 Consulte DEPLOY_KOYEB.md para mais informações.\n";
}

echo "\n";

exit($percentage === 100 ? 0 : 1);
