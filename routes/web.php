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

// resource Song
Route::resource('songs', 'Database\\SongController');

// resource LyricsBox
Route::post('/songs/{song}/boxes', 'Database\\LyricsBoxController@store')->name('lyrics_boxs.store');
Route::patch('/songs/{song}/boxes/{lyrics_box}', 'Database\\LyricsBoxController@update')->name('lyrics_boxs.update');
Route::delete('/songs/{song}/boxes/{lyrics_box}', 'Database\\LyricsBoxController@destroy')->name('lyrics_boxs.destroy');

// resource LyricsBoxLine
Route::post('/songs/{song}/boxes/{lyrics_box}/lines', 'Database\\LyricsBoxLineController@store')->name('lyrics_box_lines.store');
Route::patch('/songs/{song}/boxes/{lyrics_box}/lines/{lyrics_box_line}', 'Database\\LyricsBoxLineController@update')->name('lyrics_box_lines.update');
Route::delete('/songs/{song}/boxes/{lyrics_box}/lines/{lyrics_box_line}', 'Database\\LyricsBoxLineController@destroy')->name('lyrics_box_lines.destroy');

// song import and export
Route::get('songs/{song}/io', 'SongIoController@index')->name('songio');
Route::post('songs/{song}/io/import/old', 'SongIoController@storeAllLyricsOld')->name('songio_import_old');
Route::post('songs/{song}/io/import/both', 'SongIoController@storeAllLyricsBoth')->name('songio_import_both');
Route::post('songs/{song}/io/import/new', 'SongIoController@storeAllLyricsNew')->name('songio_import_new');
Route::get('songs/{song}/io/export/new', 'SongIoController@indexAllLyricsNew')->name('songio_export_new');
