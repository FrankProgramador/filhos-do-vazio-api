<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Character;
use App\Models\Size;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminSizeController extends Controller
{
    private function rules(?Size $size = null): array
    {
        return [
            'slug' => ['required', 'string', 'max:255', $size ? "unique:sizes,slug,{$size->id}" : 'unique:sizes,slug'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:255'],
            'poder' => ['required', 'integer'],
            'saber' => ['required', 'integer'],
            'casca' => ['required', 'integer'],
            'graca' => ['required', 'integer'],
            'coracao' => ['required', 'integer'],
            'estamina' => ['required', 'integer'],
            'alma' => ['required', 'integer'],
            'velocidade' => ['required', 'integer'],
            'fofo' => ['required', 'integer'],
            'assustador' => ['required', 'integer'],
            'sustento_inicial' => ['required', 'integer'],
            'sustento_maximo' => ['required', 'integer'],
            'order' => ['nullable', 'integer'],
        ];
    }

    public function index(): JsonResponse
    {
        return response()->json(Size::orderBy('order')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());
        $size = Size::create($data);

        return response()->json($size, 201);
    }

    public function update(Request $request, Size $size): JsonResponse
    {
        $data = $request->validate($this->rules($size));
        $size->update($data);

        return response()->json($size);
    }

    public function destroy(Size $size): JsonResponse
    {
        if (Character::where('size_id', $size->id)->exists()) {
            throw ValidationException::withMessages([
                'size' => ['Não é possível excluir: há personagens usando este tamanho.'],
            ]);
        }

        $size->delete();

        return response()->json(['message' => 'Tamanho excluído.']);
    }
}
