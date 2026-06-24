<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trigger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminTriggerController extends Controller
{
    private function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'condition_type' => ['required', 'in:none,target_health_less_than,target_has_status,caster_has_effect,custom'],
            'condition_value' => ['nullable', 'array'],
            'target_type' => ['required', 'in:self,target,allies,enemies,area'],
            'area_shape' => ['nullable', 'in:self,cone,explosion,line,cube'],
            'area_params' => ['nullable', 'array'],
        ];
    }

    public function index(): JsonResponse
    {
        return response()->json(Trigger::all());
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([...$this->rules(), 'slug' => [...$this->rules()['slug'], 'unique:triggers,slug']]);
        $trigger = Trigger::create($data);

        return response()->json($trigger, 201);
    }

    public function update(Request $request, Trigger $trigger): JsonResponse
    {
        $data = $request->validate([...$this->rules(), 'slug' => [...$this->rules()['slug'], "unique:triggers,slug,{$trigger->id}"]]);
        $trigger->update($data);

        return response()->json($trigger);
    }

    public function destroy(Trigger $trigger): JsonResponse
    {
        if ($trigger->abilities()->exists()) {
            throw ValidationException::withMessages([
                'trigger' => ['Não é possível excluir: este gatilho está em uso por habilidades.'],
            ]);
        }

        $trigger->delete();

        return response()->json(['message' => 'Gatilho excluído.']);
    }
}
