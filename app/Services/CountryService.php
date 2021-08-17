<?php

namespace App\Services;

use App\Repositories\CountryRepository;
use Illuminate\Database\Eloquent\Collection;

class CountryService
{
    private CountryRepository $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    /**
     * @return Collection
     */
    public function getCountries(): Collection
    {
        return $this->countryRepository->getCountries();
    }
}
