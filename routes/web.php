<?php

use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\CartoonsController;
use App\Http\Controllers\GuestbookPostsController;
use App\Http\Controllers\PublicationDateController;
use App\Http\Controllers\SpamController;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Route::get('/cartoon', [CartoonsController::class, 'show']);
Route::get('/cartoons/checkIfCurrentIsLastCartoon', [CartoonsController::class, 'checkIfCurrentIsLastCartoon']);

// Archive
Route::resource('/archiv', ArchiveController::class)
    ->parameters([
        'archiv' => 'date:publish_on',
    ])
    ->only(['index', 'show']);

// Protected routes
Route::middleware(Authenticate::class)->group(function () {
    Route::resource('/gaestebuch', GuestbookPostsController::class)
        ->only(['edit', 'update', 'destroy']);

    Route::get('/spam', [SpamController::class, 'index']);
    Route::get('/spam/relearn', [SpamController::class, 'relearn']);
    Route::get('/spam/{category}', [SpamController::class, 'showPosts']);

    Route::resource('/publication_dates', PublicationDateController::class)
        ->except(['create', 'store', 'show', 'destroy']);
    // @TODO: Use other controller
    Route::get('/publication_dates/forceNewCartoon', [CartoonsController::class, 'forceNewCartoon']);
});

// Close registration
Auth::routes(['register' => false]);

// Redirect routes
Route::permanentRedirect('/gästebuch', '/gaestebuch');
Route::permanentRedirect('/bücher', '/buecher');
Route::permanentRedirect('/datenschutzerklärung', '/datenschutz');
Route::permanentRedirect('/auth/login', '/login');
