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

//Auth::routes();

Route::get('/files/{fileId}/{height?}/{weight?}', 'FilesController@download');

Route::get('{all}', 'HomeController@index')->where('all', '.*');

//Route::middleware('auth')->group(function () {
//    Route::get('{all}', 'HomeController@index')->where('all', '.*');
//});