<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Character;
use App\Models\Trilha;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminTrilhaController extends Controller
{
    private function rules(?Trilha $trilha = null): array
    {
        return [
            'slug' => ['required', 'string', 'max:255', $trilha ? "unique:trilhas,slug,{$trilha->id}" : 'unique:trilhas,slug'],
            'nome' => ['required', 'string', 'max:255'],
            'tipo' => ['required', 'in:marcial,mistico'],
            'thumb' => ['nullable', 'string', 'max:255'],
            'nivel' => ['nullable', 'integer'],
            'beneficios' => ['required', 'string'],
            'barra_aumentada' => ['required', 'in:estamina,alma'],
            'aumento' => ['required', 'integer'],
        ];
    }

    public function index(): JsonResponse
    {
        return response()->json(Trilha::all());
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());
        $trilha = Trilha::create($data);

        return response()->json($trilha, 201);
    }

    public function update(Request $request, Trilha $trilha): JsonResponse
    {
        $data = $request->validate($this->rules($trilha));
        $trilha->update($data);

        return response()->json($trilha);
    }

    public function destroy(Trilha $trilha): JsonResponse
    {
        if (Character::where('trilha_id', $trilha->id)->exists()) {
            throw ValidationException::withMessages([
                'trilha' => ['Não é possível excluir: há personagens usando esta trilha.'],
            ]);
        }

        $trilha->delete();

        return response()->json(['message' => 'Trilha excluída.']);
    }
}
