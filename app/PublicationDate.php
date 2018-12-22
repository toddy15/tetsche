<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PublicationDate extends Model
{
    protected $fillable = [
        'cartoon_id',
        'publish_on',
    ];
}
