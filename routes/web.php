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
    return redirect('songs');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('songs', 'Database\\SongController');
Route::resource('lyrics_boxs', 'Database\\LyricsBoxController');
Route::resource('lyrics_box_lines', 'Database\\LyricsBoxLineController');

Route::get('songs/{song}/io', 'SongIoController@index')->name('songio');
Route::post('songs/{song}/io/import/old', 'SongIoController@storeAllLyricsOld')->name('songio_import_old');
Route::post('songs/{song}/io/import/both', 'SongIoController@storeAllLyricsBoth')->name('songio_import_both');
Route::get('songs/{song}/io/export/new', 'SongIoController@indexAllLyricsNew')->name('songio_export_new');
