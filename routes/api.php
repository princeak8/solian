<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/upload', 'IndexController@upload');

Route::post('/admin/update_product_photos', 'Admin\ProductController@update_product_photos');
Route::post('/admin/update_slides', 'Admin\ProductController@update_slides');
Route::post('/admin/update_collections', 'Admin\ProductController@update_collections');

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
    Route::post('/photo/add', 'PhotoController@add_photos');

    //Products routes
    Route::get('/products', 'ProductController@index');
    Route::get('/product/create', 'ProductController@product_form');
    Route::get('/product/edit/{id}', 'ProductController@product_form');
    Route::post('/product/save', 'ProductController@save');
    Route::post('/product/update', 'ProductController@update');
    Route::get('/product/delete/{id}', 'ProductController@delete');
    Route::post('/product/change_main', 'ProductController@change_main');
    Route::post('/product/photo/save', 'ProductController@add_photo');
    Route::get('/product/photo/delete/{id}', 'PhotoController@delete');
    Route::get('/product/{id}', 'ProductController@show');

    //collection routes
    Route::get('/collections', 'CollectionController@index');
    Route::get('/collection/create', 'CollectionController@collection_form');
    Route::get('/collection/edit/{id}', 'CollectionController@collection_form');
    Route::post('/collection/save', 'CollectionController@save');
    Route::post('/collection/photo/save', 'CollectionController@change_photo');
    Route::get('/collection/delete/{id}', 'CollectionController@delete');
    Route::get('/collection/{id}', 'CollectionController@show');

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
