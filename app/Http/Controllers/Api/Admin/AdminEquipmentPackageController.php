<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\EquipmentPackage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminEquipmentPackageController extends Controller
{
    private function rules(?EquipmentPackage $package = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', $package ? "unique:equipment_packages,slug,{$package->id}" : 'unique:equipment_packages,slug'],
            'description' => ['nullable', 'string'],
            'geo_bonus' => ['integer'],
            'image' => ['nullable', 'string', 'max:255'],
            'items' => ['array'],
            'items.*.item_id' => ['required', 'integer', 'exists:items,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function index(): JsonResponse
    {
        return response()->json(EquipmentPackage::with('items')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());
        $items = $data['items'] ?? [];
        unset($data['items']);

        $package = EquipmentPackage::create($data);
        $this->syncItems($package, $items);

        return response()->json($package->load('items'), 201);
    }

    public function update(Request $request, EquipmentPackage $equipmentPackage): JsonResponse
    {
        $data = $request->validate($this->rules($equipmentPackage));
        $items = $data['items'] ?? [];
        unset($data['items']);

        $equipmentPackage->update($data);
        $this->syncItems($equipmentPackage, $items);

        return response()->json($equipmentPackage->load('items'));
    }

    public function destroy(EquipmentPackage $equipmentPackage): JsonResponse
    {
        $equipmentPackage->delete();

        return response()->json(['message' => 'Pacote excluído.']);
    }

    private function syncItems(EquipmentPackage $package, array $items): void
    {
        $sync = [];
        foreach ($items as $item) {
            $sync[$item['item_id']] = ['quantity' => $item['quantity']];
        }
        $package->items()->sync($sync);
    }
}
