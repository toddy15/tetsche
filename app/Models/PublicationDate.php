<?php

namespace App\Models;

use Carbon\Carbon;
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

    /**
     * Return the current PublicationDate.
     */
    public static function getCurrent()
    {
        // Add 6 hours to the current time, so that the
        // cartoon is published at 18:00 one day before.
        $date = Carbon::now()->addHours(6)->format('Y-m-d');

        return PublicationDate::where('publish_on', '<=', $date)
            ->orderBy('publish_on', 'DESC')
            ->first();
    }
}
