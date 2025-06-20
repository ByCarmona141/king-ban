<?php

namespace ByCarmona141\KingBan;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Route;
use Bycarmona141\KingBan\Middleware\AuthBanned;
use ByCarmona141\KingBan\Console\Commands\KingBanCommand;



class KingBanServiceProvider extends ServiceProvider {
    public function register() {
        $this->app->bind('king-ban', function () {
            return new KingBan;
        });

        // Carga de configuracion
        $this->mergeConfigFrom($this->basePath('config/king-ban.php'), 'king-ban');
    }

    public function boot() {
        // Registro de rutas
        $this->loadRoutesFrom($this->basePath('routes/web.php'));

        // Registro de migraciones
        $this->loadMigrationsFrom(
            $this->basePath('database/migrations')
        );

        // Publicar rutas
        $this->publishes(
            [$this->basePath('routes/web.php') => base_path('routes/king-ban.php')],
            'king-ban-routes'
        );

        // Publicar configuracion
        $this->publishes(
            [$this->basePath('config/king-ban.php') => config_path('king-ban.php')],
            'king-ban-config'
        );

        // Publicar Middleware
        $this->app->make(Kernel::class)->pushMiddleware(AuthBanned::class);
    }

    protected function basePath($path = '') {
        return __DIR__ . '/../' . $path;
    }
}
