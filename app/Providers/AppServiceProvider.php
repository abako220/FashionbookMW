<?php

namespace App\Providers;

//contracts
use App\Repositories\Contracts\FreeRepositoryInterface;
use App\Repositories\Contracts\UsersInterface;
use App\Repositories\Contracts\ProductImagesInterface;
use App\Repositories\Contracts\ProductCategoryInterface;
use App\Repositories\Contracts\ProductSubCatInterface;
use App\Repositories\Contracts\StateInterface;
use App\Repositories\Contracts\LgaInterface;
use App\Repositories\Contracts\RateMerchantInterface;
use App\Repositories\Contracts\LikeProductsInterface;

//Eloquents
use App\Repositories\Eloquent\FreeAdsRepository;
use App\Repositories\Eloquent\UsersImplementation;
use App\Repositories\Eloquent\ProductCategoryImp;
use App\Repositories\Eloquent\ProductSubCatImpl;
use App\Repositories\Eloquent\ProductImagesImplementation;
use App\Repositories\Eloquent\StateImpl;
use App\Repositories\Eloquent\LgaImpl;
use App\Repositories\Eloquent\RateMerchantImpl;
use App\Repositories\Eloquent\LikeProductsImpl;

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
        $this->app->Singleton(ProductImagesInterface::class, ProductImagesImplementation::class);
        $this->app->Singleton(UsersInterface::class, UsersImplementation::class);
        $this->app->Singleton(ProductCategoryInterface::class, ProductCategoryImp::class);
        $this->app->Singleton(ProductSubCatInterface::class, ProductSubCatImpl::class);
        $this->app->Singleton(StateInterface::class, StateImpl::class);
        $this->app->Singleton(LgaInterface::class, LgaImpl::class);
        $this->app->Singleton(RateMerchantInterface::class, RateMerchantImpl::class);
        $this->app->Singleton(LikeProductsInterface::class, LikeProductsImpl::class);
        
    }
}
