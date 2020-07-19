<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');
Route::get('me', 'UserController@me')->name('users.me');
Route::get('me/edit', 'UserController@editMe')->name('users.me.edit');


Route::resource('users', 'UserController');
Route::post('users/avatar/{user}', 'UserController@avatarStore')->name('users.avatar.store');
Route::post('users/change-password/{user}', 'UserController@changePassword')->name( 'users.change-password');
Route::resource('terms', 'TermController');
