<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class SonderseiteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        $image = 'images/pyrmont-2.webp';
        $alt = 'Tetsche Cartoons im Kurpark Bad Pyrmont ';
        $alt .= 'vom 15. Mai bis 2. November 2025, ';
        $alt .= 'Dienstag bis Sonntag von 10 bis 17 Uhr. ';
        $alt .= 'Los Loide … also nix wie hin! Zur angesagten Knaller-Ausstellung im Kurpark und im Schloss!';

        return view('pages.sonderseite', [
            'description' => 'Tetsche-Website',
            'image' => $image,
            'alt' => $alt,
        ]);
    }
}
