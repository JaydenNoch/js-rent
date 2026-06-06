<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
*/

$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

// PANDUAN TOBAT: Paksa Laravel Vercel pakai /tmp semenjak lahir
if (isset($_SERVER['VERCEL_URL']) || isset($_ENV['VERCEL_URL'])) {
    
    // 1. Pindahkan folder storage (Log, Session, Views)
    $app->useStoragePath('/tmp/storage');
    
    // 2. Pindahkan folder bootstrap cache biar gak nyari /var/task/user/bootstrap/cache
    $app->bind('path.bootstrap', function () {
        return '/tmp/bootstrap';
    });
}

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

return $app;