<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CountryService;
use Illuminate\Http\Request;

class MeController extends Controller
{
    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function __invoke(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();
        $countries = $this->countryService->getCountries();
        return response()->json([
            "user" => $user,
            'countries' => $countries,
        ]);
    }
}
