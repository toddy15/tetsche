<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('gästebuch', 'GuestbookPostsController@index');
Route::get('gästebuch/neu', 'GuestbookPostsController@create');
Route::post('gästebuch', 'GuestbookPostsController@store');
