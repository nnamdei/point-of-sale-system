<?php

namespace App\Providers;

use Auth;
use View;
use Schema;
use App\User;
use App\Product;
use App\Category;
use App\Sale;
use App\Staff;
use App\Service;
use App\Shop;


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
     Schema::defaultStringLength(191); 

     View::share([
         '_product' => Product::class,
         '_category' => Category::class,
         '_sale' => Sale::class,
         '_user' => User::class,
         '_shop' => Shop::class,
         '_service' => Service::class,
         '_staff' => Staff::class,
     ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
