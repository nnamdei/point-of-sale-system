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
Route::get('/desk/close','AppController@deskClosed')->name('desk.closed');
Route::get('/no/shop','AppController@noShop')->name('no.shop');
Route::get('update','AppController@update');

Route::group(['middleware' => ['authorized','check-shop','check-desk']],function(){
    Route::get('find','DeskController@find');
    Route::get('desk','DeskController@index')->name('desk');
    Route::get('desk/products','DeskController@products')->name('desk.products');
    Route::get('desk/product/{id}','DeskController@product')->name('desk.product');
    // Route::put('desk/product/{id}/sell','DeskController@recordSale')->name('desk.sale')->middleware('sales-disabled');
    Route::get('desk/categories/','DeskController@categories')->name('desk.categories');
    Route::get('desk/category/{id}','DeskController@category')->name('desk.category');
    Route::post('desk/{user}/close','DeskController@close')->name('desk.close');
    Route::post('desk/{user}/open','DeskController@open')->name('desk.open');

    Route::get('desk/cart','CartController@cart')->name('desk.cart');
    Route::get('receipt','CartController@show')->name('cart.show');

    Route::post('desk/cart/add','CartController@add')->name('cart.add');
    Route::put('desk/cart/{item}/update','CartController@update')->name('cart.update');
    Route::put('desk/cart/{item}/remove','CartController@remove')->name('cart.remove');
    Route::get('desk/cart/empty','CartController@empty')->name('cart.empty');
    Route::post('desk/cart/checkout','CartController@checkout')->name('cart.checkout');


    Route::get('transactions','TransactionController@index')->name('transactions');
    Route::resource('staff','StaffController');
    

    Route::resource('products','ProductController');
    Route::put('product/{id}/convert/simple','ProductController@convertToSimple')->name('product.to.simple');
    Route::put('product/{id}/convert/variable','ProductController@convertToVariable')->name('product.to.variable');
    Route::put('product/{id}/reset','ProductController@reset')->name('product.reset');
    
    Route::resource('categories','CategoryController');
    Route::resource('variants','VariantController');

    Route::put('/products/{id}/stock','ProductController@stock')->name('stock');
    Route::post('/products/{id}/variables/add','ProductController@addVariables')->name('variables.add');
    Route::delete('variants/{variant_id}/{index}','VariantsController@removeSingleValue')->name('remove.value');

    Route::resource('shop','ShopController');
    Route::get('shop/checkin/{shop}', 'UserController@switchShop')->name('shop.switch');
    Route::resource('staff','StaffController');
    Route::put('staff/{id}/position','StaffController@changePosition')->name('staff.position.change');
    Route::resource('service','ServiceController');
    Route::post('service/{id}/record','ServiceController@record')->name('service.record');

});


