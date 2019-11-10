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


Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout');

Route::resource('customers', 'CustomersController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
Route::resource('products', 'ProductsController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
