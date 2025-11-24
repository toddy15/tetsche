<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SonderseiteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        $show_until = Carbon::create(2025, 12, 24, 0, 0, 0, 'Europe/Berlin');
        if (Carbon::now()->greaterThan($show_until)) {
            return (new HomepageController)($request);
        }
        $image = 'images/weihnachtskugel.webp';
        $alt = 'Bild einer Weihnachtskugel mit einem von Tetsche gezeichneten Motiv. ';
        $alt .= 'Ein Elch und ein Weihnachtsmann sitzen im Schnee, ';
        $alt .= 'die Arme um die Schultern gelegt.';

        return view('pages.sonderseite', [
            'description' => 'Tetsche-Website',
            'image' => $image,
            'alt' => $alt,
        ]);
    }
}
