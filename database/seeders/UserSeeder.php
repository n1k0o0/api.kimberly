<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->create([
            'email' => 'teymur@test.ru',
            'first_name' => 'Timur',
            'last_name' => 'Radjabov',
            'phone' => '1112223345',
            'email_verified_at' => now(),
            'status' => User::STATUS_ACTIVE,
            'password' => Hash::make('111111')
        ]);

        User::query()->create([
            'email' => 'kasparov@mail.ru',
            'first_name' => 'Qari',
            'last_name' => 'Kasparov',
            'phone' => '11122233456',
            'email_verified_at' => now(),
            'status' => User::STATUS_APPROVED,
            'password' => Hash::make('111111')
        ]);

        User::query()->create([
            'email' => 'sergey@test.ru',
            'first_name' => 'Serqey',
            'last_name' => 'Karyakin',
            'phone' => '11122233457',
            'email_verified_at' => now(),
            'status' => User::STATUS_ACTIVE,
            'password' => Hash::make('111111')
        ]);
    }
}
