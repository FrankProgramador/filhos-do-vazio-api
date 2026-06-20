<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCharacterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'age' => ['nullable', 'integer', 'min:0'],
            'species' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'string'],
            'size_id' => ['required', 'integer', 'exists:sizes,id'],
            'trilha_id' => ['required', 'integer', 'exists:trilhas,id'],
            'appearance' => ['nullable', 'string'],
            'story' => ['nullable', 'string'],

            'attr_traits' => ['array'],
            'attr_traits.*' => ['integer', 'min:1'],

            'special_traits' => ['array'],
            'special_traits.*' => ['integer', 'exists:traits,id'],

            'personality_traits' => ['required', 'array', 'size:2'],
            'personality_traits.*' => ['integer', 'exists:traits,id'],

            'sub_traits' => ['array'],
            'sub_traits.*' => ['integer', 'exists:traits,id'],

            'equipment_package_id' => ['nullable', 'integer', 'exists:equipment_packages,id'],
            'items' => ['array'],
            'items.*' => ['integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Informe o nome do personagem.',
            'size_id.required' => 'Selecione um tamanho.',
            'trilha_id.required' => 'Selecione uma trilha.',
            'personality_traits.required' => 'Escolha exatamente 2 traços de personalidade.',
            'personality_traits.size' => 'Escolha exatamente 2 traços de personalidade.',
        ];
    }
}
