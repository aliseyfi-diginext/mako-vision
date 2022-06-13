<?php

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', 'LandingController@index')->name('landing');
    Route::post('/login', 'AccController@login')->name('login');
});

Route::middleware('panel')->prefix('home')->group(function () {

    Route::get('/', 'HomeController@home')->name('home');

    // jsons
    Route::get('/jsons/list/{folder?}', 'JsonsController@list')->name('jsons');
    Route::get('/jsons/{folder}/{target}', 'JsonsController@show')->name('jsons.show');
    Route::delete('/jsons/{folder}/{target}', 'JsonsController@destroy')->name('jsons.destroy');
    Route::get('/json/download/{folder}/{target}', 'JsonsController@download')->name('jsons.download');

});
