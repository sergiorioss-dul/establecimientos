<?php

use Illuminate\Support\Facades\Route;

Route::get('/','InicioController')->name('inicio');

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth','verified']],function(){
    Route::get('/establecimiento/create','EstablecimientoController@create')->name('establecimiento.create')->middleware('revisar');
    Route::post('/establecimiento','EstablecimientoController@store')->name('establecimiento.store');
    Route::get('/establecimiento/edit','EstablecimientoController@edit')->name('establecimiento.edit');
    Route::put('/establecimiento/{establecimiento}','EstablecimientoController@update')->name('establecimiento.update');

    
    Route::post('/imagenes/store','ImagenController@store')->name('imagenes.store');
    Route::post('/imagenes/destroy','ImagenController@destroy')->name('imagenes.destroy');
});
