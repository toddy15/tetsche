<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HomepageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        $images = [
            'bonzo-lachend.webp',
            'bonzo-schutzengel.webp',
            'bonzo-traurig.webp',
        ];
        $random_image = $images[rand(0, 2)];

        return view('pages.homepage', [
            'description' => 'Tetsche-Website',
            'image_name' => $random_image,
        ]);
    }
}
