<?php

// 1. Load Autoloader Vendor
require __DIR__ . '/../vendor/autoload.php';

// 2. Buat folder temporary wajib di Vercel
if (isset($_SERVER['VERCEL_URL'])) {
    $dirs = [
        '/tmp/storage/framework/views',
        '/tmp/storage/framework/cache',
        '/tmp/storage/framework/sessions',
        '/tmp/storage/logs'
    ];
    foreach ($dirs as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }
}

// 3. Load Application Standar
$app = require_once __DIR__ . '/../bootstrap/app.php';

if (isset($_SERVER['VERCEL_URL'])) {
    $app->useStoragePath('/tmp/storage');
}

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);