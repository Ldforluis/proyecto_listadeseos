<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\CategoriasServiceInterface;
use App\Contracts\DeseosServiceInterface;
use App\Contracts\EstadosServiceInterface;
use App\Contracts\UsuariosServiceInterface;
use App\Services\CategoriasService;
use App\Services\DeseosService;
use App\Services\UsuariosService;
use App\Services\EstadosService;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(CategoriasServiceInterface::class, CategoriasService::class);
        $this->app->bind(DeseosServiceInterface::class, DeseosService::class);
        $this->app->bind(UsuariosServiceInterface::class, UsuariosService::class);
        $this->app->bind(EstadosServiceInterface::class, EstadosService::class);
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
