<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');
Route::get('users/me', 'UserController@me')->name('users.me');
Route::resource('users', 'UserController');
Route::post('users/avatar', 'UserController@avatarStore')->name('users.avatar.store');
Route::resource('terms', 'TermController');
