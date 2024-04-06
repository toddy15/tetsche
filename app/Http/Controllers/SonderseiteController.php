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
        $vorne = 'images/buch-vorderseite.webp';
        $hinten = 'images/buch-rückseite.webp';

        return view('pages.sonderseite', [
            'description' => 'Tetsche-Website',
            'vorne' => $vorne,
            'hinten' => $hinten,
        ]);
    }
}
