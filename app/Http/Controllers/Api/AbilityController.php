<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ability;
use Illuminate\Http\JsonResponse;

class AbilityController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Ability::with('triggers')->get());
    }
}
