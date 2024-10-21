<?php

namespace App\Providers;

use App\Repositories\ApiDataRepositoryInterface;
use App\Repositories\BaseApiDataRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ApiDataRepositoryInterface::class, BaseApiDataRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
