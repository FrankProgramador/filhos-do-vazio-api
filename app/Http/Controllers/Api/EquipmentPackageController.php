<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EquipmentPackage;
use Illuminate\Http\JsonResponse;

class EquipmentPackageController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(EquipmentPackage::with('items')->get());
    }
}
