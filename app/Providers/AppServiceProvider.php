<?php

namespace App\Providers;
use App\Contracts\RepositoryInterface;
use App\Eloquent\FreeAdsRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FreeRepositoryInterface::class,FreeAdsRepository::class);
    }
}
