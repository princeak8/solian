<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'IndexController@index');
Route::get('/collection/{name}', 'CollectionController@show');
Route::get('/product/{name}', 'ProductController@show');
Route::get('/contact', 'ContactController@index');

Route::get('currency/fetch_rates', 'CurrencyController@get_rates');
Route::get('currency/fetch_rate', 'CurrencyController@get_rate');
Route::get('currency/fetch_rate/{id}', 'CurrencyController@get_rate');
Route::post('currency/switch', 'CurrencyController@set_currency');

Route::get('checkout', 'OrderController@checkout_page');
Route::post('/place_order', 'OrderController@place_order');
Route::get('/payment', 'PaymentController@payment');

Route::post('register', 'UserController@create');

Route::get('login', function() {
    return view('login');
});
Route::post('login', 'AuthController@login');

Route::get('/update_dropbox_photo_url', 'DropboxController@update_dropbox_photo_url');

//Route::post('/upload', 'IndexController@upload');

//Admin routes
Route::group([
    'as'            => 'admin.',
    'prefix'        => 'admin',
    'namespace'     => 'Admin',
],function(){
    Route::get('/', 'IndexController@index');

    Route::get('/change_email', function() {
        return view('admin/change_email');
    });
    Route::get('/change_password', function() {
        return view('admin/change_password');
    });
    Route::post('/change_email', 'AdminController@change_email');
    Route::post('/change_password', 'AdminController@change_password');

    //company routes
    Route::get('/company', 'CompanyController@index');
    Route::post('/company/update_field', 'CompanyController@update_field');

    //Photo routes
    Route::get('/photos', 'PhotoController@photos');
    Route::get('/product_photos', 'PhotoController@product_photos');
    Route::get('/collection_photos', 'PhotoController@collection_photos');
    Route::get('/refresh_collection_photos', 'PhotoController@refresh_collection_photos');
    Route::get('/slide_photos', 'PhotoController@slide_photos');
    Route::get('/refresh_slide_photos', 'PhotoController@refresh_slide_photos');
    Route::post('/photo/add', 'PhotoController@add_photos');
    Route::post('/photo/add_to_category', 'PhotoController@add_to_category');
    Route::get('/photo/delete/{id}', 'PhotoController@delete');
    Route::get('/photo/remove/{id}', 'PhotoController@remove');

    Route::get('/photo/refresh/{category}', 'PhotoController@refresh_photos');

    Route::get('/refresh_dropbox_token', 'DropboxController@refresh_token');
    Route::get('/fetch_dropbox_photos', 'DropboxController@fetch_photos');

    Route::get('/photo/test', function() {
        $str = "/web/Img_234";
        $arr = explode('/', $str);
        array_shift($arr);
        $str = implode('/', $arr);
        dd($str);
    });

    Route::post('/photo/get_dropbox_photos', 'PhotoController@get_dropbox_photos');

    Route::get('/dropbox', 'IndexController@dropbox');

    //Products routes
    Route::get('/products', 'ProductController@index');
    Route::group([
        'prefix'        => '/product',
    ],function(){
        Route::get('/create', 'ProductController@product_form');
        Route::get('/edit/{id}', 'ProductController@product_form');
        Route::post('/save', 'ProductController@save');
        Route::post('/update', 'ProductController@update');
        Route::get('/delete/{id}', 'ProductController@delete');
        Route::post('/change_main', 'ProductController@change_main');
        Route::post('/photo/save', 'ProductController@add_photo');
        Route::get('/photo/delete/{id}', 'PhotoController@delete');
        Route::get('/{id}', 'ProductController@show');
    });

    //collection routes
    Route::get('/collections', 'CollectionController@index');
    Route::group([
        'prefix'        => '/collection',
    ],function(){
        Route::get('/create', 'CollectionController@collection_form');
        Route::get('/edit/{id}', 'CollectionController@collection_form');
        Route::post('/save', 'CollectionController@save');
        Route::post('/photo/save', 'CollectionController@change_photo');
        Route::get('/delete/{id}', 'CollectionController@delete');
        Route::get('/{id}', 'CollectionController@show');
    });

    //slide routes
    Route::get('/slides', 'PhotoController@slides');
    Route::get('/slide/create', function() {
        return view('admin/slide_form');
    });
    Route::post('/slide/save', 'PhotoController@add_slide');
    Route::post('/slide/delete', 'PhotoController@delete_slide');

    //order routes
    Route::get('/orders', 'OrderController@index');

    //size routes
    Route::get('/sizes', 'SizeController@index');
    Route::get('/size/edit/{id}', 'SizeController@edit');
    Route::post('/size/update', 'SizeController@update');
});

Route::group([
    'as'            => 'auth.',
    'prefix'        => 'admin',
    'namespace'     => 'Auth',
],function(){
    Route::get('/register', 'RegisterController@register_admin');
    Route::post('/register', 'RegisterController@create');
    Route::post('/login', 'AdminAuthController@login');
    Route::get('/login', 'AdminAuthController@login_page');
    Route::get('/logout', 'AdminAuthController@logout');
});
// Route::get('/admin/register', [Auth\RegisterController::class, 'register_admin']);
// Route::post('/admin/register', [Auth\RegisterController::class, 'create']);
// Route::post('/admin/login', [Auth\AdminAuthController::class, 'login']);
// Route::get('/admin/login', [Auth\AdminAuthController::class, 'login_page'])->name('admin_login');
// Route::get('/logout', [Auth\AdminAuthController::class, 'logout'])->name('admin_logout');
