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

Auth::routes();
Route::get('/dashboard', function(){
    return view('dashboard');
})->name('home');
Route::resource('/lessons', 'LessonsController');
Route::resource('/categories', 'CategoriesController');
Route::resource('/texts', 'BotTextController');
Route::resource('/telegramusers', 'TelegramusersController');
Route::get('/home', 'HomeController@index')->name('home');
