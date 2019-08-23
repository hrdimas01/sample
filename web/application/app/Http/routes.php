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

Route::group(['middleware' => 'revalidate'], function()
{
	Route::get('/', 'Auth\LoginController@index');

	Route::get('/login', 'Auth\LoginController@index')->name('login');
	Route::get('/auth', 'Auth\LoginController@index')->name('auth');
	Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

	Route::post('/authenticate', 'Auth\LoginController@authenticate')->name('authenticate');

	/* Ubah Password */
	Route::post('/password/json_save', 'ProfilController@update_password')->middleware('myauth');

	Route::get('/home', 'HomeController@index')->middleware('myauth')->name('home');

	/* Mahasiswa */
	Route::group(['prefix' => 'mahasiswa', 'middleware' => ['myauth']], function()
	{
		Route::get('/', 'MahasiswaController@index')->name('mahasiswa');
		Route::post('/json_grid', 'MahasiswaController@json');
		Route::post('/json_save', 'MahasiswaController@store'); 
		Route::get('/json_get/{id}', 'MahasiswaController@show');
		Route::post('/json_set_status', 'MahasiswaController@setAktif');
		Route::post('/json_upload/{id}', 'MahasiswaController@uploadFoto');
		Route::get('/json_load_file/{id}', 'MahasiswaController@listFoto');
		Route::post('/json_remove_file', 'MahasiswaController@deleteFoto');
	});

	/* Watch */
	Route::group(['prefix' => 'watch', 'middleware' => ['myauth']], function()
	{
		Route::get('/{nama}', 'WatchController@showFile');
	});

});