<?php

// Authentication routes...
Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');

//Route::get('auth/login', 'Auth\AuthController@getLogin');
//Route::post('auth/login', 'Auth\AuthController@postLogin');
//Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
//Route::get('auth/register', 'Auth\AuthController@getRegister');
//Route::post('auth/register', 'Auth\AuthController@postRegister');
//Route::get('auth/register', ['middleware' => 'auth', 'uses' => 'Auth\AuthController@getRegister']);
//Route::post('auth/register', ['middleware' => 'auth', 'uses' => 'Auth\AuthController@postRegister']);

// Password reset link request routes...
//Route::get('password/email', 'Auth\PasswordController@getEmail');
//Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
//Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
//Route::post('password/reset', 'Auth\PasswordController@postReset');



// Static pages
Route::get('/', 'PagesController@homepage');
Route::get('tetsche', 'PagesController@tetsche');
Route::get('bücher', 'PagesController@buecher');
Route::get('impressum', 'PagesController@impressum');
Route::get('datenschutzerklärung', 'PagesController@datenschutzerklaerung');

// Guestbook
Route::get('gästebuch', 'GuestbookPostsController@index');
Route::get('gästebuch/neu', 'GuestbookPostsController@create');
Route::post('gästebuch', 'GuestbookPostsController@store');
Route::get('gästebuch/suche', 'GuestbookPostsController@search');

// Cartoons
Route::get('cartoon', 'CartoonsController@showCurrent');
Route::get('archiv', 'CartoonsController@showArchive');
Route::get('archiv/{date}', 'CartoonsController@show');

Route::get('cartoons/checkIfCurrentIsLastCartoon', 'CartoonsController@checkIfCurrentIsLastCartoon');

// Protected routes
Route::get('gästebuch/{id}/edit', ['middleware' => 'auth', 'uses' => 'GuestbookPostsController@edit'])
    ->where('id', '[0-9]+');
Route::put('gästebuch/{id}', ['middleware' => 'auth', 'uses' => 'GuestbookPostsController@update'])
    ->where('id', '[0-9]+');
Route::delete('gästebuch/{id}', ['middleware' => 'auth', 'uses' => 'GuestbookPostsController@destroy'])
    ->where('id', '[0-9]+');

Route::get('spam', ['middleware' => 'auth', 'uses' => 'SpamController@index']);
Route::get('spam/relearn', ['middleware' => 'auth', 'uses' => 'SpamController@relearn']);
Route::get('spam/{category}', ['middleware' => 'auth', 'uses' => 'SpamController@showPosts']);

Route::get('cartoons', ['middleware' => 'auth', 'uses' => 'CartoonsController@index']);
Route::get('cartoons/neu', ['middleware' => 'auth', 'uses' => 'CartoonsController@create']);
Route::get('cartoons/forceNewCartoon', ['middleware' => 'auth', 'uses' => 'CartoonsController@forceNewCartoon']);
Route::post('cartoons', ['middleware' => 'auth', 'uses' => 'CartoonsController@store']);
Route::get('cartoons/{id}/edit', ['middleware' => 'auth', 'uses' => 'CartoonsController@edit'])
    ->where('id', '[0-9]+');
Route::put('cartoons/{id}', ['middleware' => 'auth', 'uses' => 'CartoonsController@update'])
    ->where('id', '[0-9]+');
Route::delete('cartoons/{id}', ['middleware' => 'auth', 'uses' => 'CartoonsController@destroy'])
    ->where('id', '[0-9]+');
