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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');

// customer
Route::get('/customer', 'CustomerController@index');
Route::post('/customer', 'CustomerController@store');
Route::get('/customer/{customer}', 'CustomerController@show');
Route::put('/customer/{customer}', 'CustomerController@update');
Route::delete('/customer/{customer}', 'CustomerController@destroy');

// transaction
Route::get('/transaction', 'TransactionController@index');
Route::get('/transaction/create', 'TransactionController@create');
Route::post('/transaction', 'TransactionController@store');
Route::get('/transaction/{transaction}', 'TransactionController@show');
Route::get('/transaction/{transaction}/edit', 'TransactionController@edit');
Route::delete('/transaction/{transaction}', 'TransactionController@destroy');

// kota
Route::get('/kota/{kota}', 'KotaController@show');

// detail
Route::post('/detail', 'DetailController@store');
Route::get('/detail/{detail}', 'DetailController@show');
Route::put('/detail/{detail}', 'DetailController@update');
Route::post('/detail/add', 'DetailController@add');
Route::delete('/detail/{detail}', 'DetailController@destroy');

Route::get('/welcome', function () {
    return view('welcome');
});
