<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notification\ResetPassword;
use App\Repositories\Interfaces\UsuarioRepositoryInterface;
use App\Repositories\UsuarioRepository;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Repositories\AuthRepository;
use App\Repositories\AgendaMedicaRepository;
use App\Repositories\Interfaces\AgendaMedicaRepositoryInterface;
use App\Repositories\TurnoRepository;
use App\Services\TurnoService;
use App\Repositories\MedicoRepository;
use App\Services\MedicoService;
use App\Services\AgendaMedicaService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        //Repositorios
        $this->app->bind(UsuarioRepositoryInterface::class, UsuarioRepository::class);
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(AgendaMedicaRepositoryInterface::class, AgendaMedicaRepository::class);
        $this->app->bind(TurnoRepository::class, TurnoRepository::class);
        $this->app->bind(MedicoRepository::class, MedicoRepository::class);
        
        // Servicios
        $this->app->bind(TurnoService::class, function ($app) {
            return new TurnoService(
                $app->make(TurnoRepository::class),
                $app->make(AgendaMedicaService::class),
                $app->make(AgendaMedicaRepository::class)
            );
        });
        $this->app->bind(MedicoService::class, function ($app) {
            return new MedicoService($app->make(MedicoRepository::class));
        });
        


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
