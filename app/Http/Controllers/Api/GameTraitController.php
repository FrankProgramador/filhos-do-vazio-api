<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GameTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GameTraitController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = GameTrait::with(['modifiers', 'subTraits']);

        if ($request->filled('category')) {
            $query->where('category', $request->string('category'));
        }
        if ($request->filled('rarity')) {
            $query->where('rarity', $request->string('rarity'));
        }

        return response()->json($query->get());
    }
}
