<?php

namespace Database\Seeders;

use App\Models\InternalUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InternalUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InternalUser::query()->create([
            'login' => 'admin',
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'middle_name' => 'Admin',
            'phone' => '1112223345',
            'type' => InternalUser::TYPE_SUPER_ADMIN,
            'password' => Hash::make('111111')
        ]);

        InternalUser::query()->create([
            'login' => 'jury',
            'first_name' => 'Just',
            'last_name' => 'Jury',
            'phone' => '11122233456',
            'type' => InternalUser::TYPE_JURY,
            'password' => Hash::make('111111')
        ]);
    }
}
