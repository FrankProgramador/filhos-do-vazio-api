<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trigger;
use Illuminate\Http\JsonResponse;

class TriggerController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Trigger::all());
    }
}
