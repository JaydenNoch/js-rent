<?php

// 1. Definisikan folder kustom ke /tmp secara runtime SEBELUM Laravel di-load
if (isset($_SERVER['VERCEL_URL'])) {
    $_ENV['APP_STORAGE_PATH'] = '/tmp/storage';
    
    // Buat foldernya secara fisik di /tmp jika belum ada
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

// 2. Load aplikasi Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. Paksa aplikasi menggunakan jalur folder /tmp tersebut
if (isset($_SERVER['VERCEL_URL'])) {
    $app->useStoragePath('/tmp/storage');
    
    // Trik pamungkas memindahkan bootstrap cache path ke /tmp secara instan
    $app->bind('path.bootstrap', function () {
        return '/tmp/bootstrap';
    });
}

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);