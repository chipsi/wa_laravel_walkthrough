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
    return redirect(route('person::list'));
});

Route::get('/osoby', 'PersonsList@show')->name('person::list');
Route::post('/osoby/smazat/{id}', 'PersonsList@delete')->name('person::delete');

Route::get('/osoby/vytvorit', 'PersonsList@create')->name('person::create');
Route::post('/osoby/pridat', 'PersonsList@insert')->name('person::insert');