<?php

use App\Http\Controllers\CartoonsController;
use App\Http\Controllers\GuestbookPostsController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\SpamController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Authentication routes
Auth::routes();

// Static pages
Route::get('/', [PagesController::class, 'homepage']);
Route::get('tetsche', [PagesController::class, 'tetsche']);
Route::get('bücher', [PagesController::class, 'buecher']);
Route::get('impressum', [PagesController::class, 'impressum']);
Route::get('datenschutzerklärung', [PagesController::class, 'datenschutzerklaerung']);

// Guestbook
Route::get('gästebuch', [GuestbookPostsController::class, 'index']);
Route::get('gästebuch/neu', [GuestbookPostsController::class, 'create']);
Route::post('gästebuch', [GuestbookPostsController::class, 'store']);
Route::get('gästebuch/suche', [GuestbookPostsController::class, 'search']);

// Cartoons
Route::get('cartoon', [CartoonsController::class, 'showCurrent']);
Route::get('archiv', [CartoonsController::class, 'showArchive']);
Route::get('archiv/{date}', [CartoonsController::class, 'show']);

Route::get('cartoons/checkIfCurrentIsLastCartoon', [CartoonsController::class, 'checkIfCurrentIsLastCartoon']);

// Protected routes
Route::get('gästebuch/{id}/edit', ['middleware' => 'auth', 'uses' => [GuestbookPostsController::class, 'edit']])
    ->where('id', '[0-9]+');
Route::put('gästebuch/{id}', ['middleware' => 'auth', 'uses' => [GuestbookPostsController::class, 'update']])
    ->where('id', '[0-9]+');
Route::delete('gästebuch/{id}', ['middleware' => 'auth', 'uses' => [GuestbookPostsController::class, 'destroy']])
    ->where('id', '[0-9]+');

Route::get('spam', ['middleware' => 'auth', 'uses' => [SpamController::class, 'index']]);
Route::get('spam/relearn', ['middleware' => 'auth', 'uses' => [SpamController::class, 'relearn']]);
Route::get('spam/{category}', ['middleware' => 'auth', 'uses' => [SpamController::class, 'showPosts']]);

Route::get('cartoons', ['middleware' => 'auth', 'uses' => [CartoonsController::class, 'index']]);
Route::get('cartoons/neu', ['middleware' => 'auth', 'uses' => [CartoonsController::class, 'create']]);
Route::get('cartoons/forceNewCartoon', ['middleware' => 'auth', 'uses' => [CartoonsController::class, 'forceNewCartoon']]);
Route::post('cartoons', ['middleware' => 'auth', 'uses' => [CartoonsController::class, 'store']]);
Route::get('cartoons/{id}/edit', ['middleware' => 'auth', 'uses' => [CartoonsController::class, 'edit']])
    ->where('id', '[0-9]+');
Route::put('cartoons/{id}', ['middleware' => 'auth', 'uses' => [CartoonsController::class, 'update']])
    ->where('id', '[0-9]+');
Route::delete('cartoons/{id}', ['middleware' => 'auth', 'uses' => [CartoonsController::class, 'destroy']])
    ->where('id', '[0-9]+');
