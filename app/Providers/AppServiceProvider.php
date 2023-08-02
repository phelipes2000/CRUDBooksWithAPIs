<?php

namespace App\Providers;

use App\Repositories\{BookEloquentORM, BookRepositoryInterface};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            //SupportRepositoryInterface::class,
            BookRepositoryInterface::class,
            //SupportEloquentORM::class
            BookEloquentORM::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
