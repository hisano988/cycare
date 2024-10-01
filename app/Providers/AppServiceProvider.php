<?php

namespace App\Providers;

use App\Domain\Repository\PeriodRecordRepository;
use App\Infrastructure\RepositoryImpl\PeriodRecordRepositoryImpl;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

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
            return new PeriodRecordRepositoryImpl();
        });
    }
}
