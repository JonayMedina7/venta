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

Route::get('/', function () {
    return view('welcome');
});

route::get('/product', 'ProductController@index');
route::post('/product/register', 'ProductController@store');
// route::put('/product/update', 'ProductController@update');
route::put('/product/desactive', 'ProductController@desactive');
route::put('/product/active', 'ProductController@active');