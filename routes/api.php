<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/establecimientos','APIController@index')->name('establecimientos.index');
Route::get('/establecimientos/{establecimiento}','APIController@show')->name('establecimientos.show');
Route::get('/categorias','APIController@categorias')->name('categorias');
Route::get('/categorias/{categoria}','APIController@categoria')->name('categoria');
Route::get('/{categoria}','APIController@establecimientoscategoria')->name('establecimientoscategoria');