<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PublicationDate extends Model
{
    protected $fillable = [
        'cartoon_id',
        'publish_on',
    ];

    /**
     * Get the cartoon that has this publication date.
     */
    public function cartoon()
    {
        return $this->belongsTo('App\Cartoon');
    }
}
