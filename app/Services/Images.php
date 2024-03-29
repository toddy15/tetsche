<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Class Images
 *
 * Various functions for rotating a random image.
 */
class Images
{
    /**
     * Return an <img> tag with a random image.
     */
    public function getRandomImageForGuestbook(): string
    {
        $directory = 'images/gb_animals';
        $image = $this->getRandomImage($directory);
        $size = getimagesize(public_path().'/'.$image);
        $url = asset($image);
        $name = $this->getNameFromFilename($image);
        $result = '<img src="'.$url.'" ';
        if (is_array($size)) {
            $result .= $size[3];
        }
        $result .= ' alt="'.$name.'" title="'.$name.'" />';

        return $result;
    }

    /**
     * Get a random image from the given directory.
     */
    private function getRandomImage(string $directory): string
    {
        $images = $this->getImagesInDirectory(public_path().'/'.$directory);
        $num = mt_rand(0, count($images) - 1);

        return $directory.'/'.$images[$num];
    }

    /**
     * Return an array of all files in the given directory.
     *
     * @return array<int, string>
     */
    private function getImagesInDirectory(string $directory): array
    {
        $images = [];
        $dir = opendir($directory);
        while (($file = readdir($dir)) !== false) {
            // Strip ., .., and subdirs
            if (is_file($directory.'/'.$file)) {
                $images[] = $file;
            }
        }
        closedir($dir);
        sort($images);

        return $images;
    }

    private function getNameFromFilename(string $filename): string
    {
        // Extract the filename without extension
        $filename = pathinfo($filename, PATHINFO_FILENAME);
        // Turn special characters into human-readable forms
        $filename = str_replace(
            ['ae', 'oe', 'ue', 'Ae', 'Oe', 'Ue', '_'],
            ['ä', 'ö', 'ü', 'Ä', 'Ö', 'Ü', ' '],
            $filename,
        );

        return ucwords($filename);
    }
}
