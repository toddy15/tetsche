<?php

declare(strict_types=1);

use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\CartoonsController;
use App\Http\Controllers\ExhibitionsController;
use App\Http\Controllers\GuestbookPostsController;
use App\Http\Controllers\GuestBookSearchController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\NewCartoonController;
use App\Http\Controllers\PublicationDateController;
use App\Http\Controllers\SonderseiteController;
use App\Http\Controllers\SpamController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Static pages
Route::view('/tetsche', 'pages.tetsche', [
    'title' => 'Über Tetsche',
    'description' => 'Informationen über Tetsche',
])->name('tetsche');

Route::view('/buecher', 'pages.buecher', [
    'title' => 'Bücher',
    'description' => 'Bücher von Tetsche',
])->name('buecher');

Route::view('/impressum', 'pages.impressum', [
    'title' => 'Impressum',
    'description' => 'Impressum, Kontaktadressen und Anbieterkennzeichnung der Tetsche-Website',
])->name('impressum');

Route::view('/datenschutz', 'pages.datenschutz', [
    'title' => 'Datenschutzerklärung',
    'description' => 'Datenschutzerklärung der Tetsche-Website',
])->name('datenschutz');

// Homepage
//Route::get('/', HomepageController::class)->name('homepage');
Route::get('/', SonderseiteController::class)->name('homepage');

// Guestbook
Route::resource('/gaestebuch', GuestbookPostsController::class)->only([
    'index',
    'create',
]);
// Use rate limiting only for storing new entries: 30 entries in 60 minutes
Route::resource('/gaestebuch', GuestbookPostsController::class)->only([
    'store',
])->middleware('throttle:public_comment');
Route::get('/gaestebuch/suche', GuestBookSearchController::class);

// Cartoons
Route::get('/cartoon', CartoonsController::class);
// @todo: Choose better route
Route::get('/cartoons/checkIfCurrentIsLastCartoon', [
    NewCartoonController::class,
    'checkIfCurrentIsLastCartoon',
]);

// Archive
Route::resource('/archiv', ArchiveController::class)
    ->parameters([
        'archiv' => 'date:publish_on',
    ])
    ->only(['index', 'show']);

// Exhibitions
Route::resource('/ausstellungen', ExhibitionsController::class)
    ->only(['index']);

// Protected routes
Route::middleware('auth')->group(function () {
    Route::resource('/gaestebuch', GuestbookPostsController::class)->only([
        'edit',
        'update',
        'destroy',
    ]);

    Route::get('/spam', [SpamController::class, 'index']);
    Route::get('/spam/relearn', [SpamController::class, 'relearn']);
    Route::get('/spam/{category}', [SpamController::class, 'showPosts']);

    Route::resource(
        '/publication_dates',
        PublicationDateController::class,
    )->except(['create', 'store', 'show', 'destroy']);
    // @TODO: Use other controller
    Route::get('/publication_dates/forceNewCartoon', [
        NewCartoonController::class,
        'forceNewCartoon',
    ]);

    // Exhibitions
    Route::resource('/ausstellungen', ExhibitionsController::class)
        ->except(['index', 'show']);
});

// Close registration
Auth::routes(['register' => false]);

// Redirect routes
Route::permanentRedirect('/gästebuch', '/gaestebuch');
Route::permanentRedirect('/bücher', '/buecher');
Route::permanentRedirect('/datenschutzerklärung', '/datenschutz');
Route::permanentRedirect('/auth/login', '/login');
