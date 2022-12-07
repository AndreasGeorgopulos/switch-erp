<?php

use Illuminate\Http\Request;

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

Route::get('/products', 'Api\ProductController@index');
Route::get('/products/{index}', 'Api\ProductController@index');
Route::post('/products/add_new_order', 'Api\ProductController@addNewOrder');