<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exhibition extends Model
{
    use HasFactory;

    public $fillable = [
        'title',
        'description',
        'image',
        'show_until',
    ];

    public function image_width()
    {
        $size = getimagesize(public_path().'/images/exhibitions/'
            .$this->image);

        return $size ? $size[0] : 0;
    }

    public function image_height()
    {
        $size = getimagesize(public_path().'/images/exhibitions/'.$this->image);

        return $size ? $size[1] : 0;
    }
}
