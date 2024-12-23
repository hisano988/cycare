<?php

namespace App\Providers;

use App\Domain\Repositories\PeriodRecordRepository;
use App\Domain\Repositories\UserRepository;
use App\Infrastructure\RepositoryImpls\PeriodRecordRepositoryImpl;
use App\Infrastructure\RepositoryImpls\UserRepositoryImpl;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Repository
        $this->app->singleton(PeriodRecordRepository::class, function (Application $app) {
            return new PeriodRecordRepositoryImpl;
        });
        $this->app->singleton(UserRepository::class, function (Application $app) {
            return new UserRepositoryImpl;
        });
    }
}
