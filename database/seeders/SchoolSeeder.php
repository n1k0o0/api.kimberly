<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\User;
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
            'user_id' => User::where('email', 'teymur@test.ru')->first()->id,
            'city_id' => 1,
            'name' => 'Sporting',
            'status' => School::STATUS_PUBLISHED,
        ]);
        School::query()->create([
            'user_id' => User::where('email', 'kasparov@mail.ru')->first()->id,
            'city_id' => 1,
            'name' => 'Manchester',
            'status' => School::STATUS_PUBLISHED,
        ]);
        School::query()->create([
            'user_id' => User::where('email', 'sergey@test.ru')->first()->id,
            'city_id' => 1,
            'name' => 'Juventus',
            'status' => School::STATUS_MODERATION,
        ]);
    }
}
