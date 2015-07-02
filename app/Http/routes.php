<?php

Route::get('/', 'PagesController@homepage');
Route::get('tetsche', 'PagesController@tetsche');
Route::get('impressum', 'PagesController@impressum');

Route::get('gästebuch', 'GuestbookPostsController@index');
Route::get('gästebuch/neu', 'GuestbookPostsController@create');
Route::post('gästebuch', 'GuestbookPostsController@store');
