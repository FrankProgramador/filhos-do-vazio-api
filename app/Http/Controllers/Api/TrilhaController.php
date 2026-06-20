<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trilha;
use Illuminate\Http\JsonResponse;

class TrilhaController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Trilha::all());
    }
}
