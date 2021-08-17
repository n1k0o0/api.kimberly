<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CountryAndCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $russia = Country::query()->create([
            'name' => 'Россия'
        ]);
        $cities = Collection::make(['Москва', 'Санкт-Петербург', 'Новосибирск', 'Красноярск', 'Воронеж', 'Омск', 'Сочи']);
        $preparedCities = Collection::empty();
        $cities->each(fn ($cityItem) => $preparedCities->push([
            'country_id' => $russia->id,
            'name' => $cityItem,
        ]));

        DB::table('cities')->insert($preparedCities->toArray());
    }
}
