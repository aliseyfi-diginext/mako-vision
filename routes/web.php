<?php

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', 'LandingController@index')->name('landing');
    Route::post('/login', 'AccController@login')->name('login');
});

Route::middleware('panel')->prefix('home')->group(function () {

    Route::get('/', 'HomeController@home')->name('home');
    Route::get('/jsons/{target?}', 'HomeController@jsons')->name('jsons');
    Route::get('/json/download/{target}', 'HomeController@downloadJson')->name('jsons.download');

});
