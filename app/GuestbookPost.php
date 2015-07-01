<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuestbookPost extends Model
{
    protected $fillable = [
        'name',
        'message',
        'cheffe',
    ];
}
