<?php

namespace Database\Seeders;

use App\Models\School;
use Faker\Factory;
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
        $faker = Factory::create();
        /** @var School $school */
        $school = School::query()->create([
           'status' => School::STATUS_MODERATION,
           'user_id' => 1,
           'city_id' => 2,
           'name' => $faker->realText(22),
           'description' => $faker->realText(100),
           'email' => $faker->email(),
           'phone' =>  $faker->phoneNumber(),
        ]);
        $school->coaches()->create([
            'first_name' => $faker->firstName(), 'last_name' => $faker->lastName(), 'patronymic' => $faker->lastName(),
        ]);
        $school->coaches()->create([
            'first_name' => $faker->firstName(), 'last_name' => $faker->lastName(), 'patronymic' => $faker->lastName(),
        ]);
        $school->coaches()->create([
            'first_name' => $faker->firstName(), 'last_name' => $faker->lastName(), 'patronymic' => $faker->lastName(),
        ]);

        $school->teams()->create([
            'division_id' => 1,
            'color_id' => 1,
        ]);
        $school->teams()->create([
            'division_id' => 2,
            'color_id' => 2,
        ]);
        $school->teams()->create([
            'division_id' => 3,
            'color_id' => 3,
        ]);


        $school = School::query()->create([
            'status' => School::STATUS_PUBLISHED,
            'user_id' => 1,
            'city_id' => 3,
            'name' => $faker->realText(22),
            'description' => $faker->realText(100),
            'email' =>  $faker->email(),
            'phone' =>  $faker->phoneNumber(),
        ]);
        $school->coaches()->create([
            'first_name' => $faker->firstName(), 'last_name' => $faker->lastName(), 'patronymic' => $faker->lastName(),
        ]);
        $school->coaches()->create([
            'first_name' => $faker->firstName(), 'last_name' => $faker->lastName(), 'patronymic' => $faker->lastName(),
        ]);
        $school->coaches()->create([
            'first_name' => $faker->firstName(), 'last_name' => $faker->lastName(), 'patronymic' => $faker->lastName(),
        ]);
        $school->teams()->create([
            'division_id' => 1,
            'color_id' => 1,
        ]);
        $school->teams()->create([
            'division_id' => 2,
            'color_id' => 2,
        ]);
        $school->teams()->create([
            'division_id' => 3,
            'color_id' => 3,
        ]);
    }
}
