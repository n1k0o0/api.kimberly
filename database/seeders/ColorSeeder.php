<?php

namespace Database\Seeders;

use App\Models\TeamColor;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TeamColor::query()->create([
            'color' => 'red',
            'rgb' => '#ff0000',
        ]);
        TeamColor::query()->create([
            'color' => 'green',
            'rgb' => '#00ff00',
        ]);
        TeamColor::query()->create([
            'color' => 'blue',
            'rgb' => '#0000ff',
        ]);
    }
}
