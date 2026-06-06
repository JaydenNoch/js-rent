<?php

// 1. Ambil fungsi bawaan composer duluan biar aman
require __DIR__ . '/../vendor/autoload.php';

// 2. Buat struktur folder di /tmp Vercel secara fisik agar writable
if (isset($_SERVER['VERCEL_URL'])) {
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

// 3. Baru panggil app.php yang udah kita pasang bind path tadi
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);