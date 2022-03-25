<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
     * Check if the PublicationDate is currently in the archive.
     */
    public function isArchived(): bool
    {
        $archived = self::archived()->get();
        foreach ($archived as $a) {
            if ($this->publish_on === $a->publish_on) {
                return true;
            }
        }

        return false;
    }

    /**
     * Scope the query to archived dates.
     */
    public function scopeArchived(Builder $query): Builder
    {
        $current = self::getCurrent();

        return $query->where('publish_on', '<', $current->publish_on)
            ->latest('publish_on')
            ->take(16);
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

    /**
     * Get the cartoon that has this publication date.
     */
    public function cartoon(): BelongsTo
    {
        return $this->belongsTo(Cartoon::class);
    }
}
