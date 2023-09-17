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

    protected $fillable = ['filename', 'rebus'];

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
        $path = public_path().'/'.$this->filename;
        if (is_file($path)) {
            $size = getimagesize($path);
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
     * Return thumbnail size, alt and title attributes.
     */
    public function thumbnailSizeAndDescription(): string
    {
        $date = Carbon::parse($this->lastPublishOn())
            ->locale('de')
            ->isoFormat('Do MMMM YYYY');
        $result = 'alt="Tetsche – Cartoon der Woche . . . vom '.$date.'" ';
        $thumbnail = str_replace('.cartoon.', '.thumbnail.', $this->filename);
        $path = public_path().'/'.$thumbnail;
        if (is_file($path)) {
            $size = getimagesize($path);
            if (is_array($size)) {
                $result .= $size[3];
            }
        }

        return $result;
    }
}
