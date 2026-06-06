<?php

// 1. Ambil autoloader Composer
require __DIR__ . '/../vendor/autoload.php';

// 2. Siapkan folder writable di memori temporary Vercel (/tmp)
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

    // Buat file manifest dummy di /tmp agar Laravel tidak mencoba menulis ke folder read-only
    if (!file_exists('/tmp/bootstrap/cache/packages.php')) {
        file_put_contents('/tmp/bootstrap/cache/packages.php', '<?php return [];');
    }
    if (!file_exists('/tmp/bootstrap/cache/services.php')) {
        file_put_contents('/tmp/bootstrap/cache/services.php', '<?php return [];');
    }
}

// 3. Muat aplikasi Laravel bawaan
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 4. Paksa Laravel mengalihkan path storage dan manifest cache ke /tmp
if (isset($_SERVER['VERCEL_URL'])) {
    $app->useStoragePath('/tmp/storage');
    
    // Alihkan pencarian file manifest ke file dummy di /tmp yang sudah kita buat tadi
    $app->setBootstrapPackagesPath('/tmp/bootstrap/cache/packages.php');
    $app->setBootstrapProvidersPath('/tmp/bootstrap/cache/services.php');
}

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);