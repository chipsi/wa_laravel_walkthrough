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
    return redirect(route('login'));
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
	Route::get('/osoby', 'PersonsList@show')->name('person::list');
	Route::post('/osoby/smazat/{id}', 'PersonsList@delete')->name('person::delete');

	Route::get('/osoby/vytvorit', 'PersonsList@create')->name('person::create');
	Route::post('/osoby/pridat', 'PersonsList@insert')->name('person::insert');

	Route::get('/osoby/editace/{id}', 'PersonsList@edit')->name('person::edit');
	Route::post('/osoby/ulozit/{id}', 'PersonsList@update')->name('person::update');
});
