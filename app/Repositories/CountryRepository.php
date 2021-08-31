<?php

namespace App\Repositories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Collection;

class CountryRepository
{
    /**
     * @return Collection
     */
    public function getCountries(): Collection
    {
        return Country::query()->with('cities', 'cities.leagues', 'cities.leagues.divisions')->get();
    }
}
