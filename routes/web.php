<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'AppController@index')->name('index');
Route::group(['middleware' => 'authorized'],function(){
    Route::get('/find','DeskController@find');
    Route::get('/desk','DeskController@index')->name('desk');
    Route::get('/desk/products','DeskController@products')->name('desk.products');
    Route::get('/desk/product/{id}','DeskController@product')->name('desk.product');
    Route::put('desk/product/{id}/sell','DeskController@recordSale')->name('desk.sale')->middleware('sales-disabled');
    Route::get('/desk/categories/','DeskController@categories')->name('desk.categories');
    Route::get('/desk/category/{id}','DeskController@category')->name('desk.category');

    Route::get('desk/cart','CartController@cart')->name('cart');
    Route::post('desk/cart/add','CartController@add')->name('cart.add');


    Route::get('transactions','TransactionsController@index')->name('transactions');
    Route::resource('users','UsersController');
    Route::resource('products','ProductsController');
    Route::resource('categories','CategoriesController');
    Route::resource('variants','VariantsController');
    Route::put('/products/{id}/stock','ProductsController@stock')->name('stock');
    Route::post('/products/{id}/variables/add','ProductsController@addVariables')->name('variables.add');
    Route::delete('variants/{variant_id}/{index}','VariantsController@removeSingleValue')->name('remove.value');
});


