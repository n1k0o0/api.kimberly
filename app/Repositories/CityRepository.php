<?php

namespace App\Repositories;

use App\Models\City;
use Illuminate\Database\Eloquent\Collection;

class CityRepository
{
    /**
     * @param int $countryId
     *
     * @return Collection
     */
    public function getCitiesByCountryId(int $countryId): Collection
    {
        return City::query()->where('country_id', $countryId)->get();
    }
}
