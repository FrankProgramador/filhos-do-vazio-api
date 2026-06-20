<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[Fillable(['slug', 'name', 'description', 'type', 'duration_type', 'duration_value', 'tags', 'icon'])]
class Effect extends Model
{
    protected function casts(): array
    {
        return [
            'tags' => 'array',
        ];
    }

    public function modifiers(): MorphMany
    {
        return $this->morphMany(Modifier::class, 'target');
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'item_effects');
    }

    public function traits(): BelongsToMany
    {
        return $this->belongsToMany(GameTrait::class, 'trait_effects', 'effect_id', 'trait_id');
    }
}
