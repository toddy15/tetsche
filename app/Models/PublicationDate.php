<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PublicationDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'cartoon_id',
        'publish_on',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'publish_on';
    }

    /**
     * Get the cartoon that has this publication date.
     */
    public function cartoon(): BelongsTo
    {
        return $this->belongsTo(Cartoon::class);
    }
}
