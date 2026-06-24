<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[Fillable([
    'name', 'slug', 'description', 'type', 'activation_cost', 'cooldown', 'is_magic', 'is_unique', 'image',
])]
class Ability extends Model
{
    protected function casts(): array
    {
        return [
            'activation_cost' => 'array',
            'is_magic' => 'boolean',
            'is_unique' => 'boolean',
        ];
    }

    public function triggers(): BelongsToMany
    {
        return $this->belongsToMany(Trigger::class, 'ability_triggers');
    }

    public function modifiers(): MorphMany
    {
        return $this->morphMany(Modifier::class, 'target');
    }

    public function abilitySources(): HasMany
    {
        return $this->hasMany(AbilitySource::class);
    }

    public function characters(): BelongsToMany
    {
        return $this->belongsToMany(Character::class, 'character_abilities')
            ->withPivot(['source_type', 'source_id', 'quantity', 'uses_remaining']);
    }
}
