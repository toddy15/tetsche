<?php

// Authentication
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
//Route::get('auth/login', 'Auth\AuthController@getLogin');
//Route::post('auth/login', 'Auth\AuthController@postLogin');
//Route::get('auth/logout', 'Auth\AuthController@getLogout');
//
//// Password routes
//Route::get('password/email', 'Auth\PasswordController@getEmail');
//Route::post('password/email', 'Auth\PasswordController@postEmail');
//
//// Registration routes
//Route::get('auth/register', 'Auth\AuthController@getRegister');
//Route::post('auth/register', 'Auth\AuthController@postRegister');

// Static pages
Route::get('/', 'PagesController@homepage');
Route::get('tetsche', 'PagesController@tetsche');
Route::get('impressum', 'PagesController@impressum');

Route::get('gästebuch', 'GuestbookPostsController@index');
Route::get('gästebuch/neu', 'GuestbookPostsController@create');
Route::post('gästebuch', 'GuestbookPostsController@store');
// Protected routes
Route::get('gästebuch/{id}/edit', 'GuestbookPostsController@edit');
Route::put('gästebuch/{id}', 'GuestbookPostsController@update');
