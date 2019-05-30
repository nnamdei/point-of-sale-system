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
Route::get('installation/migrate', 'InstallationController@migrate');
Route::get('installation/seed', 'InstallationController@seed');
Route::get('installation/symlink', 'InstallationController@symlink');
Route::get('installation/post-installation', 'InstallationController@postInstallation');

Route::get('system/status','SystemController@status')->name('system.status');
Route::get('scanner',function(){
    Session::put('scanner',request()->power);
    echo json_encode(['status' => request()->power]);
})->name('scanner.power');
Route::group(['middleware' => ['system-status']], function(){
    Route::get('/', 'AppController@index')->name('index');
    Route::post('admin','AdminController@store')->name('admin.store');
});


Route::group(['middleware' => ['system-status','authorized']],function(){
    Route::get('/desk/close','AppController@deskClosed')->name('desk.closed');
    Route::get('/no/shop','AppController@noShop')->name('no.shop');
    Route::resource('shop','ShopController');
    Route::get('shop/checkin/{shop}', 'UserController@switchShop')->name('shop.switch')->middleware('admin');
});
    
Route::group(['middleware' => ['system-status','authorized','check-shop','check-desk']],function(){
    Route::get('find','ProductController@find')->name('product.find');
    Route::get('desk','DeskController@index')->name('desk');
    Route::post('desk/scan','BarcodeController@addToCartWithScanner')->name('scan.to.cart');
    Route::get('desk/products','DeskController@products')->name('desk.products');
    Route::get('desk/product/{id}','DeskController@product')->name('desk.product');
    // Route::put('desk/product/{id}/sell','DeskController@recordSale')->name('desk.sale')->middleware('sales-disabled');
    Route::get('desk/categories/','DeskController@categories')->name('desk.categories');
    Route::get('desk/category/{id}','DeskController@category')->name('desk.category');
    Route::post('desk/{user}/close','DeskController@close')->name('desk.close');
    Route::post('desk/{user}/open','DeskController@open')->name('desk.open');

    Route::get('desk/cart','CartController@cart')->name('desk.cart');
    Route::post('desk/cart/add','CartController@add')->name('cart.add');
    Route::put('desk/cart/{item}/update','CartController@update')->name('cart.update');
    Route::put('desk/cart/{item}/remove','CartController@remove')->name('cart.remove');
    Route::get('desk/cart/empty','CartController@empty')->name('cart.empty');
    Route::post('desk/cart/checkout','CartController@checkout')->name('cart.checkout');


    Route::get('transactions','TransactionController@index')->name('transactions');
    Route::get('receipt','TransactionController@verifyReceipt')->name('receipt.verify');
    Route::delete('transaction/sale/{id}/revoke', 'TransactionController@revokeSale')->name('sale.revoke');

    Route::resource('staff','StaffController');
    Route::get('password','UserController@editPassword')->name('user.password.edit');
    Route::put('password','UserController@updatePassword')->name('user.password.update');

    Route::resource('products','ProductController');
    Route::post('product/{id}/barcode/attach','BarcodeController@attachBarcode')->name('product.barcode.attach');
    Route::post('product/{id}/barcode/generate','BarcodeController@generateBarcode')->name('product.barcode.generate');
    Route::delete('product/{id}/barcode/remove','BarcodeController@removeBarcode')->name('product.barcode.remove');
    Route::get('product/barcode/{id}','BarcodeController@printBarcode')->name('product.barcode.print');
    Route::put('product/{id}/convert/simple','ProductController@convertToSimple')->name('product.to.simple');
    Route::put('product/{id}/convert/variable','ProductController@convertToVariable')->name('product.to.variable');
    Route::put('product/{id}/reset','ProductController@reset')->name('product.reset');
    Route::put('/products/{id}/stock','ProductController@stock')->name('stock');
    Route::post('/products/{id}/variables/add','ProductController@addVariables')->name('variables.add');
    Route::delete('variants/{variant_id}/{index}','VariantController@removeSingleValue')->name('remove.value');
    
    Route::resource('categories','CategoryController');
    Route::resource('variants','VariantController');


    Route::get('shop/{id}/lowstock','ShopController@lowStocks')->name('shop.low.stocks');
    Route::get('shop/{id}/setting','ShopController@edit')->name('shop.setting');
    Route::put('shop/{id}/setting/product','ShopController@updateProductSetting')->name('shop.setting.product');
    Route::put('shop/{id}/setting/service','ShopController@updateServiceSetting')->name('shop.setting.service')->middleware('premium');
    
    Route::resource('staff','StaffController');
    Route::put('staff/{id}/position','StaffController@changePosition')->name('staff.position.change');
    Route::resource('service','ServiceController');
    Route::post('service/{id}/record','ServiceRecordController@record')->name('service.record');

});
Route::group(['middleware' => ['system-status','authorized', 'admin']], function(){
    Route::get('barcode/generate','BarcodeController@generateRandomBarcode')->name('barcode.generate');
    Route::get('backup', 'BackupController@index')->name('backup.index');
    Route::get('backup/create', 'BackupController@create')->name('backup.create');
    Route::get('backup/download/{file_name}', 'BackupController@download')->name('backup.download');
    Route::get('backup/delete/{file_name}', 'BackupController@delete')->name('backup.delete');
});

Route::group(['middleware' => 'superadmin'],function(){
    Route::get('system','SystemController@setup')->name('system');
    Route::put('system','SystemController@update')->name('system.update');
    Route::get('system/clear-cache','SystemController@clearSystemCache')->name('system.cache.clear');
    Route::post('system/artisan','SystemController@runArtisan')->name('system.artisan.run');
});




