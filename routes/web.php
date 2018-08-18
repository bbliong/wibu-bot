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


Route::prefix('admin')->group(function () {
	Route::get('/', 'HomeController@index')->name('home');
    Route::get('/posts', 'adminController@posts');
    Route::get('/replies', 'adminController@replies');
    Route::get('/logs', 'adminController@logs');
    Route::delete('/delete/{id}', 'adminController@delete');
    Route::put('/insert/{id}', 'adminController@insert');
    Route::post('/upload', 'uploadController@index');
    Route::get('/upload', 'uploadController@show');
    Route::get('/home', 'HomeController@index')->name('home');
});

Route::match(['post', 'get'], '/linebot', 'LineBotController@index');


Route::get('/waifu', 'waifuController@index');
Route::post('/waifu', 'waifuController@get');



Auth::routes();



