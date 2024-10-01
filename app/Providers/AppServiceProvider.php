<?php

namespace App\Providers;

use App\Domain\Repositories\PeriodRecordRepository;
use App\Infrastructure\RepositoryImpls\PeriodRecordRepositoryImpl;
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
