<?php

declare(strict_types=1);

namespace App\Services;

use Carbon\Carbon;

class Cartoons
{
    /**
     * Helper method to determine the next thursday.
     */
    public function getNextThursday(string $date = ''): string
    {
        $dt = new Carbon($date);
        if ($dt->dayOfWeek !== Carbon::THURSDAY) {
            $dt->next(Carbon::THURSDAY);
        }

        return $dt->format('Y-m-d');
    }

    /**
     * Helper method to determine the last thursday.
     */
    public function getLastThursday(string $date = ''): string
    {
        $dt = new Carbon($date);
        if ($dt->dayOfWeek !== Carbon::THURSDAY) {
            $dt->previous(Carbon::THURSDAY);
        }

        return $dt->format('Y-m-d');
    }
}
