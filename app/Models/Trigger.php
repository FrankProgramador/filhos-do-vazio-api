<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable([
    'name', 'slug', 'description', 'condition_type', 'condition_value',
    'target_type', 'area_shape', 'area_params',
])]
class Trigger extends Model
{
    protected function casts(): array
    {
        return [
            'condition_value' => 'array',
            'area_params' => 'array',
        ];
    }

    public function abilities(): BelongsToMany
    {
        return $this->belongsToMany(Ability::class, 'ability_triggers');
    }
}
