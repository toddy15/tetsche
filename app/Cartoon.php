<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cartoon extends Model
{
    protected $fillable = [
        'publish_on',
        'random_number',
        'rebus',
    ];
}
