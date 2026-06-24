<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ability;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AdminAbilityController extends Controller
{
    private function rules(?Ability $ability = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', $ability ? "unique:abilities,slug,{$ability->id}" : 'unique:abilities,slug'],
            'description' => ['required', 'string'],
            'type' => ['required', 'in:active,passive,reaction'],
            'activation_cost' => ['nullable', 'array'],
            'cooldown' => ['integer', 'min:0'],
            'is_magic' => ['boolean'],
            'is_unique' => ['boolean'],
            'image' => ['nullable', 'string', 'max:255'],
            'trigger_ids' => ['array'],
            'trigger_ids.*' => ['integer', 'exists:triggers,id'],
        ];
    }

    public function index(): JsonResponse
    {
        return response()->json(Ability::with('triggers')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());
        $triggerIds = $data['trigger_ids'] ?? [];
        unset($data['trigger_ids']);

        $ability = DB::transaction(function () use ($data, $triggerIds) {
            $ability = Ability::create($data);
            $ability->triggers()->sync($triggerIds);

            return $ability;
        });

        return response()->json($ability->load('triggers'), 201);
    }

    public function update(Request $request, Ability $ability): JsonResponse
    {
        $data = $request->validate($this->rules($ability));
        $triggerIds = $data['trigger_ids'] ?? [];
        unset($data['trigger_ids']);

        DB::transaction(function () use ($ability, $data, $triggerIds) {
            $ability->update($data);
            $ability->triggers()->sync($triggerIds);
        });

        return response()->json($ability->load('triggers'));
    }

    public function destroy(Ability $ability): JsonResponse
    {
        if ($ability->characters()->exists()) {
            throw ValidationException::withMessages([
                'ability' => ['Não é possível excluir: esta habilidade está em uso por personagens.'],
            ]);
        }

        $ability->delete();

        return response()->json(['message' => 'Habilidade excluída.']);
    }
}
