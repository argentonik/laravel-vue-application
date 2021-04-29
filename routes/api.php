<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login')->name('login');
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', 'AuthController@logout');
    Route::get('/currentUser', 'AuthController@user');

    Route::get('/bulletins/create', 'BulletinController@create')->name('bulletins/create');
    Route::get('/bulletins/create', 'BulletinController@create')->name('bulletins/create');
    Route::post('/bulletins/{id}/update', 'BulletinController@update')->name('bulletins/update');
    Route::post('/bulletins/store', 'BulletinController@store')->name('bulletins/store');
});

Route::get('/bulletins', 'BulletinController@index')->name('bulletins');

Route::get('/bulletins/{id}', 'BulletinController@show')->name('bulletins/show');

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user()->id;
// });

