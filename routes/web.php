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
    return redirect()->to(route('home'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('regional', 'RegionalController');
Route::resource('substation', 'SubstationController');
Route::resource('measuring-point', 'MeasuringPointController');
Route::post('/upload', 'FileController@upload')->name('upload');

