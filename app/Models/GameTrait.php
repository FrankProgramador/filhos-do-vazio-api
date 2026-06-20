<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[Fillable([
    'slug', 'name', 'category', 'rarity', 'description', 'mechanical_effect', 'roleplay_obligation',
    'sustento_cost', 'max_selections', 'is_inherent', 'prerequisite_trait_id', 'thumb',
])]
class GameTrait extends Model
{
    protected $table = 'traits';

    protected function casts(): array
    {
        return [
            'is_inherent' => 'boolean',
        ];
    }

    public function prerequisite(): BelongsTo
    {
        return $this->belongsTo(GameTrait::class, 'prerequisite_trait_id');
    }

    public function subTraits(): HasMany
    {
        return $this->hasMany(GameTrait::class, 'prerequisite_trait_id');
    }

    public function modifiers(): MorphMany
    {
        return $this->morphMany(Modifier::class, 'target');
    }

    public function effects(): BelongsToMany
    {
        return $this->belongsToMany(Effect::class, 'trait_effects', 'trait_id', 'effect_id');
    }

    public function characters(): BelongsToMany
    {
        return $this->belongsToMany(Character::class, 'character_traits', 'trait_id', 'character_id')
            ->withPivot(['quantity', 'is_inherent', 'is_personality', 'is_extra']);
    }

    public function scopeCommon(Builder $query): Builder
    {
        return $query->where('rarity', 'common');
    }

    public function scopeRemarkable(Builder $query): Builder
    {
        return $query->where('rarity', 'remarkable');
    }

    public function scopeRare(Builder $query): Builder
    {
        return $query->where('rarity', 'rare');
    }

    public function scopePersonality(Builder $query): Builder
    {
        return $query->where('rarity', 'personality');
    }
}
