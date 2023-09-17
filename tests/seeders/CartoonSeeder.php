<?php

declare(strict_types=1);

namespace Tests\Seeders;

use App\Models\Cartoon;
use App\Models\PublicationDate;
use Illuminate\Database\Seeder;

class CartoonSeeder extends Seeder
{
    /**
     * Seed database with cartoons.
     */
    public function run(): void
    {
        $dates = [
            '2021-11-25', // not available anymore
            '2021-12-02', // oldest date in the archive
            '2021-12-09',
            '2021-12-16',
            '2021-12-23',
            '2021-12-30',
            '2022-01-06',
            '2022-01-13',
            '2022-01-20',
            '2022-01-27',
            '2022-02-03',
            '2022-02-10',
            '2022-02-17',
            '2022-02-24',
            '2022-03-03',
            '2022-03-10',
            '2022-03-17', // newest date in the archive
            '2022-03-24', // current
            '2022-03-31', // future cartoon
        ];

        foreach ($dates as $date) {
            PublicationDate::factory()->create([
                'publish_on' => $date,
                'cartoon_id' => Cartoon::factory()->create(),
            ]);
        }
    }
}
