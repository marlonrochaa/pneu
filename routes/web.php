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
    return view('auth.login');
});


Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Auth::routes();


Route::group(['prefix' => 'marca', 'where' => ['id' => '[0-9]+'],'middleware' => 'auth' ] ,function() {
        Route::get('', ['as' => 'marca.index', 'uses' => 'MarcaController@index']);
        Route::get('/list',['as' => 'marca.list', 'uses' => 'MarcaController@list']);
        Route::get('/modelos/{id}',['as' => 'marca.modelos', 'uses' => 'MarcaController@modelos']);
        Route::post('/store', ['as' => 'marca.store', 'uses' => 'MarcaController@store']);
        Route::post('/update', ['as' => 'marca.update', 'uses' => 'MarcaController@update']);
        Route::post('/delete', ['as' => 'marca.destroy', 'uses' => 'MarcaController@destroy']);
});

Route::group(['prefix' => 'modelo', 'where' => ['id' => '[0-9]+'],'middleware' => 'auth' ] ,function() {
        Route::get('', ['as' => 'modelo.index', 'uses' => 'ModeloController@index']);
        Route::get('/list',['as' => 'modelo.list', 'uses' => 'ModeloController@list']);
        Route::post('/store', ['as' => 'modelo.store', 'uses' => 'ModeloController@store']);
        Route::post('/update', ['as' => 'modelo.update', 'uses' => 'ModeloController@update']);
        Route::post('/delete', ['as' => 'modelo.destroy', 'uses' => 'ModeloController@destroy']);
});

Route::group(['prefix' => 'pneu', 'where' => ['id' => '[0-9]+'], 'middleware' => 'auth' ] ,function() {
        Route::get('', ['as' => 'pneu.index', 'uses' => 'PneuController@index']);
        Route::get('/list',['as' => 'pneu.list', 'uses' => 'PneuController@list']);
        Route::post('/store', ['as' => 'pneu.store', 'uses' => 'PneuController@store']);
        Route::post('/update', ['as' => 'pneu.update', 'uses' => 'PneuController@update']);
        Route::post('/delete', ['as' => 'pneu.destroy', 'uses' => 'PneuController@destroy']);
});