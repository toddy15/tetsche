<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cartoon extends Model
{
    use HasFactory;

    protected $fillable = ['publish_on', 'random_number', 'rebus'];

    /**
     * Get the publication dates of the cartoon.
     */
    public function publicationDate(): HasMany
    {
        return $this->hasMany(PublicationDate::class)->orderBy(
            'publish_on',
            'DESC',
        );
    }

    /**
     * Return image size, alt and title attributes.
     */
    public function imageSizeAndDescription(): string
    {
        $date = Carbon::parse($this->lastPublishOn())
            ->locale('de')
            ->isoFormat('Do MMMM YYYY');
        $result = 'alt="Tetsche – Cartoon der Woche . . . vom '.$date.'" ';
        if (is_file(public_path().'/'.$this->imagePath())) {
            $size = getimagesize(public_path().'/'.$this->imagePath());
            if (is_array($size)) {
                $result .= $size[3];
            }
        }

        return $result;
    }

    /**
     * Get the publication dates of the cartoon.
     */
    public function lastPublishOn(): string
    {
        return $this->publicationDate->first()->publish_on;
    }

    /**
     * Return the path to the image.
     */
    public function imagePath(): string
    {
        $path = 'images/cartoons/';
        $path .= $this->publish_on;
        $path .= '.cartoon.';
        $path .= $this->random_number;
        $path .= '.jpg';

        return $path;
    }

    /**
     * Return thumbnail size, alt and title attributes.
     */
    public function thumbnailSizeAndDescription(): string
    {
        $date = Carbon::parse($this->lastPublishOn())
            ->locale('de')
            ->isoFormat('Do MMMM YYYY');
        $result = 'alt="Tetsche – Cartoon der Woche . . . vom '.$date.'" ';
        if (is_file(public_path().'/'.$this->thumbnailPath())) {
            $size = getimagesize(public_path().'/'.$this->thumbnailPath());
            if (is_array($size)) {
                $result .= $size[3];
            }
        }

        return $result;
    }

    /**
     * Return the path to the thumbnail.
     */
    public function thumbnailPath(): string
    {
        $path = 'images/cartoons/';
        $path .= $this->publish_on;
        $path .= '.thumbnail.';
        $path .= $this->random_number;
        $path .= '.jpg';

        return $path;
    }
}
