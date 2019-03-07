<?php

namespace App\Providers;

use View;
use Schema;
use App\User;
use App\Product;
use App\Category;
use App\Transaction;

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
     date_default_timezone_set('Africa/Lagos');

     View::share([
         'PRODUCTS' => Product::all(),
         'PRODUCTS_' => Product::where('id','>',0),
         'CATEGORIES' => Category::all(),
         'CATEGORIES_' => Category::where('id','>',0),
         'TRANSACTIONS' => Transaction::where('id','>',0),
         'USERS' => User::all(),
         'USERS_' => User::where('id','>',0)
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
