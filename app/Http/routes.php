<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/gästebuch', 'GuestbookPostsController@index');
