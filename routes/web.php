<?php

use App\Http\Controllers\CartoonsController;
use App\Http\Controllers\GuestbookPostsController;
use App\Http\Controllers\SpamController;
use App\Http\Middleware\Authenticate;
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
Route::view('/', 'pages.homepage', [
    'description' => 'Tetsche-Website',
])->name('homepage');

Route::view('/tetsche', 'pages.tetsche', [
    'title' => 'Über Tetsche',
    'keywords' => 'Informationen, Information',
    'description' => 'Informationen über Tetsche',
])->name('tetsche');

Route::view('/buecher', 'pages.buecher', [
    'title' => 'Bücher',
    'keywords' => 'Buch, Bücher, Buchveröffentlichung',
    'description' => 'Bücher von Tetsche',
])->name('buecher');

Route::view('/impressum', 'pages.impressum', [
    'title' => 'Impressum',
    'keywords' => 'Impressum, Kontakt, Anbieterkennzeichnung',
    'description' => 'Impressum, Kontaktadressen und Anbieterkennzeichnung der Tetsche-Website',
])->name("impressum");

Route::view('/datenschutz', 'pages.datenschutz', [
    'title' => 'Datenschutzerklärung',
    'keywords' => 'Datenschutzerklärung, Datenschutz, DSGVO',
    'description' => 'Datenschutzerklärung der Tetsche-Website',
])->name('datenschutz');

// Guestbook
Route::resource('/gaestebuch', GuestbookPostsController::class)
    ->only(['index', 'create', 'store']);
Route::get('/gaestebuch/suche', [GuestbookPostsController::class, 'search']);

// Cartoons
Route::get('/cartoon', [CartoonsController::class, 'showCurrent']);
Route::get('/archiv', [CartoonsController::class, 'showArchive']);
Route::get('/archiv/{date}', [CartoonsController::class, 'show']);

Route::get('/cartoons/checkIfCurrentIsLastCartoon', [CartoonsController::class, 'checkIfCurrentIsLastCartoon']);

// Protected routes
Route::middleware(Authenticate::class)->group(function () {
    Route::resource('/gaestebuch', GuestbookPostsController::class)
        ->only(['edit', 'update', 'destroy']);

    Route::get('/spam', [SpamController::class, 'index']);
    Route::get('/spam/relearn', [SpamController::class, 'relearn']);
    Route::get('/spam/{category}', [SpamController::class, 'showPosts']);

    Route::get('/cartoons', [CartoonsController::class, 'index']);
    Route::get('/cartoons/forceNewCartoon', [CartoonsController::class, 'forceNewCartoon']);
    Route::get('/cartoons/{id}/edit', [CartoonsController::class, 'edit'])
        ->where('id', '[0-9]+');
    Route::put('/cartoons/{id}', [CartoonsController::class, 'update'])
        ->where('id', '[0-9]+');
    Route::delete('/cartoons/{id}', [CartoonsController::class, 'destroy'])
        ->where('id', '[0-9]+');
});

// Close registration
Auth::routes(['register' => false]);
