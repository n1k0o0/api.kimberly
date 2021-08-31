<?php

namespace Database\Seeders;

use App\Models\School;
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
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            InternalUserSeeder::class,
            CountryAndCitySeeder::class,
            ColorSeeder::class,
            SchoolSeeder::class,
        ]);

    }
}
