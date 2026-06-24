<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameTrait;
use App\Models\Modifier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AdminGameTraitController extends Controller
{
    private function rules(?GameTrait $trait = null): array
    {
        return [
            'slug' => ['required', 'string', 'max:255', $trait ? "unique:traits,slug,{$trait->id}" : 'unique:traits,slug'],
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:body,senses,movement,defense,social,mystic,personality'],
            'rarity' => ['required', 'in:common,remarkable,rare,personality'],
            'description' => ['required', 'string'],
            'mechanical_effect' => ['nullable', 'string'],
            'roleplay_obligation' => ['nullable', 'string'],
            'sustento_cost' => ['integer'],
            'max_selections' => ['integer', 'min:1'],
            'is_inherent' => ['boolean'],
            'prerequisite_trait_id' => ['nullable', 'integer', 'exists:traits,id'],
            'thumb' => ['nullable', 'string', 'max:255'],
            'modifiers' => ['array'],
            'modifiers.*.attribute' => ['required', 'string'],
            'modifiers.*.operation' => ['required', 'in:add,subtract,multiply,set'],
            'modifiers.*.value' => ['required', 'integer'],
        ];
    }

    public function index(): JsonResponse
    {
        return response()->json(GameTrait::with(['modifiers', 'subTraits'])->get());
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());
        $modifiers = $data['modifiers'] ?? [];
        unset($data['modifiers']);

        $trait = DB::transaction(function () use ($data, $modifiers) {
            $trait = GameTrait::create($data);
            $this->syncModifiers($trait, $modifiers);

            return $trait;
        });

        return response()->json($trait->load(['modifiers', 'subTraits']), 201);
    }

    public function update(Request $request, GameTrait $trait): JsonResponse
    {
        $data = $request->validate($this->rules($trait));

        if ((int) ($data['prerequisite_trait_id'] ?? 0) === $trait->id) {
            throw ValidationException::withMessages([
                'prerequisite_trait_id' => ['Um traço não pode ser pré-requisito de si mesmo.'],
            ]);
        }

        $modifiers = $data['modifiers'] ?? [];
        unset($data['modifiers']);

        DB::transaction(function () use ($trait, $data, $modifiers) {
            $trait->update($data);
            $this->syncModifiers($trait, $modifiers);
        });

        return response()->json($trait->load(['modifiers', 'subTraits']));
    }

    public function destroy(GameTrait $trait): JsonResponse
    {
        if ($trait->characters()->exists()) {
            throw ValidationException::withMessages([
                'trait' => ['Não é possível excluir: este traço está em uso por personagens.'],
            ]);
        }
        if ($trait->subTraits()->exists()) {
            throw ValidationException::withMessages([
                'trait' => ['Não é possível excluir: outros traços dependem deste como pré-requisito.'],
            ]);
        }

        $trait->delete();

        return response()->json(['message' => 'Traço excluído.']);
    }

    private function syncModifiers(GameTrait $trait, array $modifiers): void
    {
        Modifier::where('target_type', GameTrait::class)->where('target_id', $trait->id)->delete();

        foreach ($modifiers as $modifier) {
            Modifier::create([
                'target_type' => GameTrait::class,
                'target_id' => $trait->id,
                'attribute' => $modifier['attribute'],
                'operation' => $modifier['operation'],
                'value' => $modifier['value'],
            ]);
        }
    }
}
