<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MeController extends Controller
{
    public function __invoke(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $user->load([
            "roles",
            "permissions",
            "moderated"
        ]);

        return response()->json([
            "user" => $user,
            'test' => 'test'
        ]);
    }
}
