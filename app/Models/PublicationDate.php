<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicationDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'cartoon_id',
        'publish_on',
    ];

    /**
     * Get the cartoon that has this publication date.
     */
    public function cartoon()
    {
        return $this->belongsTo('App\Models\Cartoon');
    }
}
