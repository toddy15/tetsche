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

// Static pages
Route::get('/', [PagesController::class, 'homepage']);
Route::get('tetsche', [PagesController::class, 'tetsche']);
Route::get('bücher', [PagesController::class, 'buecher']);
Route::get('impressum', [PagesController::class, 'impressum'])->name("impressum");
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
Route::middleware('auth')->group(function () {
    Route::get('gästebuch/{id}/edit', [GuestbookPostsController::class, 'edit'])
        ->where('id', '[0-9]+');
    Route::put('gästebuch/{id}', [GuestbookPostsController::class, 'update'])
        ->where('id', '[0-9]+');
    Route::delete('gästebuch/{id}', [GuestbookPostsController::class, 'destroy'])
        ->where('id', '[0-9]+');

    Route::get('spam', [SpamController::class, 'index']);
    Route::get('spam/relearn', [SpamController::class, 'relearn']);
    Route::get('spam/{category}', [SpamController::class, 'showPosts']);

    Route::get('cartoons', [CartoonsController::class, 'index']);
    Route::get('cartoons/forceNewCartoon', [CartoonsController::class, 'forceNewCartoon']);
    Route::get('cartoons/{id}/edit', [CartoonsController::class, 'edit'])
        ->where('id', '[0-9]+');
    Route::put('cartoons/{id}', [CartoonsController::class, 'update'])
        ->where('id', '[0-9]+');
    Route::delete('cartoons/{id}', [CartoonsController::class, 'destroy'])
        ->where('id', '[0-9]+');
});

Auth::routes();
