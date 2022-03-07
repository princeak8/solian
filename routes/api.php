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
