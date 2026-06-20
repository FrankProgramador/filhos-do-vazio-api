<?php

use App\Http\Controllers\Api\Admin\AdminEquipmentPackageController;
use App\Http\Controllers\Api\Admin\AdminGameTraitController;
use App\Http\Controllers\Api\Admin\AdminItemController;
use App\Http\Controllers\Api\Admin\AdminSizeController;
use App\Http\Controllers\Api\Admin\AdminTrilhaController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CharacterController;
use App\Http\Controllers\Api\EquipmentPackageController;
use App\Http\Controllers\Api\GameTraitController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\SizeController;
use App\Http\Controllers\Api\TrilhaController;
use App\Http\Controllers\Api\UploadController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::get('/sizes', [SizeController::class, 'index']);
Route::get('/traits', [GameTraitController::class, 'index']);
Route::get('/items', [ItemController::class, 'index']);
Route::get('/equipment-packages', [EquipmentPackageController::class, 'index']);
Route::get('/trilhas', [TrilhaController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (\Illuminate\Http\Request $request) {
        $user = $request->user();

        return [...$user->toArray(), 'is_admin' => $user->hasRole('admin')];
    });

    Route::post('/uploads/avatar', [UploadController::class, 'avatar']);

    Route::apiResource('characters', CharacterController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::post('/characters/{character}/traits', [CharacterController::class, 'addTrait']);
    Route::patch('/characters/{character}/personality', [CharacterController::class, 'swapPersonality']);
    Route::post('/characters/{character}/items', [CharacterController::class, 'addItem']);

    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::apiResource('sizes', AdminSizeController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::apiResource('trilhas', AdminTrilhaController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::apiResource('items', AdminItemController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::apiResource('traits', AdminGameTraitController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::apiResource('equipment-packages', AdminEquipmentPackageController::class)->only(['index', 'store', 'update', 'destroy']);
    });
});
