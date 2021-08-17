<?php

namespace App\Services;

use App\Repositories\CityRepository;
use Illuminate\Database\Eloquent\Collection;

class CityService
{
    private CityRepository $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function getCities(int $countryId): Collection
    {
        return $this->cityRepository->getCitiesByCountryId($countryId);
    }
}
