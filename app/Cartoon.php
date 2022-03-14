<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cartoon extends Model
{
    use HasFactory;

    protected $fillable = [
        'publish_on',
        'random_number',
        'rebus',
    ];

    /**
     * Get the publication dates of the cartoon.
     */
    public function publicationDate()
    {
        return $this->hasMany('App\PublicationDate')->orderBy('publish_on', 'DESC');
    }

    /**
     * Return image size, alt and title attributes.
     */
    public function imageSizeAndDescription()
    {
        $date = Carbon::parse($this->lastPublishOn())->formatLocalized('%e. %B %Y');
        $result = 'alt="Tetsche - Cartoon der Woche . . . vom '.$date.'" ';
        $result .= 'title="Tetsche - Cartoon der Woche . . . vom '.$date.'" ';
        if (is_file(public_path().'/'.$this->imagePath())) {
            $size = getimagesize(public_path().'/'.$this->imagePath());
            $result .= $size[3];
        }

        return $result;
    }

    /**
     * Get the publication dates of the cartoon.
     */
    public function lastPublishOn()
    {
        return $this->publicationDate->first()->publish_on;
    }

    /**
     * Return the path to the image.
     */
    public function imagePath()
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
    public function thumbnailSizeAndDescription()
    {
        $date = Carbon::parse($this->lastPublishOn())->formatLocalized('%e. %B %Y');
        $result = 'alt="Tetsche - Cartoon der Woche . . . vom '.$date.'" ';
        $result .= 'title="Tetsche - Cartoon der Woche . . . vom '.$date.'" ';
        if (is_file(public_path().'/'.$this->thumbnailPath())) {
            $size = getimagesize(public_path().'/'.$this->thumbnailPath());
            $result .= $size[3];
        }

        return $result;
    }

    /**
     * Return the path to the thumbnail.
     */
    public function thumbnailPath()
    {
        $path = 'images/cartoons/';
        $path .= $this->publish_on;
        $path .= '.thumbnail.';
        $path .= $this->random_number;
        $path .= '.jpg';

        return $path;
    }
}
