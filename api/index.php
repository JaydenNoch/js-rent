<?php

// Paksa system PHP tahu kalau folder bootstrap cache dipindah ke /tmp
if (isset($_SERVER['VERCEL_URL'])) {
    putenv('LARAVEL_BOOTSTRAP_CACHE=/tmp/bootstrap/cache');
    $_ENV['LARAVEL_BOOTSTRAP_CACHE'] = '/tmp/bootstrap/cache';

    $dirs = [
        '/tmp/storage/framework/views',
        '/tmp/storage/framework/cache',
        '/tmp/storage/framework/sessions',
        '/tmp/storage/logs',
        '/tmp/bootstrap/cache'
    ];
    
    foreach ($dirs as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }
}

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);