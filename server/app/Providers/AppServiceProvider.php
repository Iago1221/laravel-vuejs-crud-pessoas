<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\User\UserRepository::class,
            \App\Infrastructure\User\EloquentUserRepository::class
        );

        $this->app->bind(
            \App\Domain\Pessoa\PessoaRepository::class,
            \App\Infrastructure\Pessoa\EloquentPessoaRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
