<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
*/

// OVERRIDE SAKTI: Kita paksa method bootstrapPath() mengembalikan folder /tmp jika di Vercel
$app = new class($_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)) extends Illuminate\Foundation\Application {
    public function bootstrapPath($path = '')
    {
        if (isset($_SERVER['VERCEL_URL'])) {
            return '/tmp/bootstrap' . ($path ? DIRECTORY_SEPARATOR . $path : '');
        }
        return parent::bootstrapPath($path);
    }
};

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
*/

if (isset($_SERVER['VERCEL_URL'])) {
    $app->useStoragePath('/tmp/storage');
}

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