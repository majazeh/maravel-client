<?php

use Illuminate\Support\Facades\Route;

Route::get('auth', 'AuthController@authForm')->name('auth');
Route::post('auth', 'AuthController@auth');

Route::get('auth/theory/{key}', 'AuthController@authTheoryForm')->name('auth.theory');
Route::post('auth/theory/{key}', 'AuthController@authTheory');


Route::get('register', 'AuthController@register')->name('register');
Route::get('auth/recovery', 'AuthController@recovery')->name('auth.recovery');
Route::get('auth/verification', 'AuthController@verification')->name('auth.verification');

Route::post('logout', 'AuthController@logout')->name('logout')->middleware('auth');

Route::get('auth/as', 'AuthController@authAs')->name('auth.as');
