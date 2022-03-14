<?php

namespace Database\Seeders;

use App\PublicationDate;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         PublicationDate::factory(30)->create();
    }
}
