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
        $path = 'images/homepage/';
        $images = scandir(public_path($path));
        // Remove . and .. from list
        $images = array_diff($images, ['.', '..']);
        // Append the directories
        $images = array_map(fn (string $filename): string => $path.$filename, $images);
        // Pick a random image
        $index = array_rand($images);
        $random_image = $images[$index];

        // @TODO: Get width and height, create <img> tag
        return view('pages.homepage', [
            'description' => 'Tetsche-Website',
            'image_name' => $random_image,
        ]);
    }
}
