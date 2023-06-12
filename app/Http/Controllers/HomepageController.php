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
        // Ensure an array, if scandir returned false
        $images = scandir(public_path($path)) ?: [];
        // Remove ., .., and .gitkeep from list
        $images = array_filter($images,
            fn (string $filename) => ! str_starts_with($filename, '.')
        );
        // Set a sensible default, if there are no images available.
        $random_image = 'images/tetsche-2019.jpg';
        if (count($images)) {
            // Append the directories
            $images = array_map(
                fn (string $filename): string => $path.$filename,
                $images
            );
            // Pick a random image
            $index = array_rand($images);
            $random_image = $images[$index];
        }
        // Get information for selected image
        $imageinfo = getimagesize(public_path($random_image));
        $width = '100';
        $height = '100';
        if (is_array($imageinfo)) {
            $width = $imageinfo[0];
            $height = $imageinfo[1];
        }

        return view('pages.homepage', [
            'description' => 'Tetsche-Website',
            'src' => $random_image,
            'width' => $width,
            'height' => $height,
        ]);
    }
}
