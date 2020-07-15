<?php

use Illuminate\Support\Facades\Route;

Route::get('auth', 'AuthController@authForm')->name('auth');
Route::post('auth', 'AuthController@auth');

Route::get('auth/theory/{key}', 'AuthController@authTheoryForm')->name('auth.theory');
Route::post('auth/theory/{key}', 'AuthController@authTheory');

Route::get('register', 'AuthController@registerForm')->name('register');
Route::post('register', 'AuthController@register');

Route::get('auth/recovery', 'AuthController@recoveryForm')->name('auth.recovery');
Route::post('auth/recovery', 'AuthController@recovery');

Route::get('auth/verification', 'AuthController@verification')->name('auth.verification');

Route::post('logout', 'AuthController@logout')->name('logout')->middleware('auth');

Route::post('auth/as/{user}', 'AuthController@authAs')->name('auth.as')->middleware('auth');
Route::post('auth/back/', 'AuthController@authBack')->name('auth.back')->middleware('auth');
