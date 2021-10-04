<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        School::query()->create([
            'user_id' => 1,
            'city_id' => 1,
            'name' => 'Sporting',
            'status' => School::STATUS_PUBLISHED,
        ]);
        School::query()->create([
            'user_id' => 2,
            'city_id' => 1,
            'name' => 'Manchester',
            'status' => School::STATUS_PUBLISHED,
        ]);
        School::query()->create([
            'user_id' => 2,
            'city_id' => 1,
            'name' => 'Juventus',
            'status' => School::STATUS_MODERATION,
        ]);
    }
}
