<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Interfaces\AuthInterface;
use App\Interfaces\TaskInterface;

use App\Repository\AuthRepository;
use App\Repository\TaskRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthInterface::class, AuthRepository::class);
        $this->app->bind(TaskInterface::class, TaskRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
