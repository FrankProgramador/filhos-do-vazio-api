<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminItemController extends Controller
{
    private function rules(?Item $item = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', $item ? "unique:items,slug,{$item->id}" : 'unique:items,slug'],
            'description' => ['nullable', 'string'],
            'weight' => ['required', 'numeric'],
            'quality' => ['nullable', 'string', 'max:255'],
            'base_price' => ['required', 'integer'],
            'durability' => ['nullable', 'integer'],
            'is_consumable' => ['boolean'],
            'type' => ['required', 'in:weapon,armor,shield,tool,consumable,accessory,other'],
            'image' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function index(): JsonResponse
    {
        return response()->json(Item::all());
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());
        $item = Item::create($data);

        return response()->json($item, 201);
    }

    public function update(Request $request, Item $item): JsonResponse
    {
        $data = $request->validate($this->rules($item));
        $item->update($data);

        return response()->json($item);
    }

    public function destroy(Item $item): JsonResponse
    {
        if ($item->characters()->exists() || $item->equipmentPackages()->exists()) {
            throw ValidationException::withMessages([
                'item' => ['Não é possível excluir: este item está em uso por personagens ou pacotes de equipamento.'],
            ]);
        }

        $item->delete();

        return response()->json(['message' => 'Item excluído.']);
    }
}
