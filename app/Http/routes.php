<?php

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
//Route::get('auth/register', ['middleware' => 'auth', 'uses' => 'Auth\AuthController@getRegister']);
//Route::post('auth/register', ['middleware' => 'auth', 'uses' => 'Auth\AuthController@postRegister']);

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

// Static pages
Route::get('/', 'PagesController@homepage');
Route::get('tetsche', 'PagesController@tetsche');
Route::get('impressum', 'PagesController@impressum');

Route::get('gästebuch', 'GuestbookPostsController@index');
Route::get('gästebuch/neu', 'GuestbookPostsController@create');
Route::post('gästebuch', 'GuestbookPostsController@store');
// Protected routes
Route::get('gästebuch/{id}/edit', ['middleware' => 'auth', 'uses' => 'GuestbookPostsController@edit']);
Route::put('gästebuch/{id}', ['middleware' => 'auth', 'uses' => 'GuestbookPostsController@update']);
Route::delete('gästebuch/{id}', ['middleware' => 'auth', 'uses' => 'GuestbookPostsController@destroy']);
Route::get('spam', ['middleware' => 'auth', 'uses' => 'SpamController@index']);
Route::get('spam/relearn', ['middleware' => 'auth', 'uses' => 'SpamController@relearn']);
Route::get('spam/{category}', ['middleware' => 'auth', 'uses' => 'SpamController@showPosts']);
