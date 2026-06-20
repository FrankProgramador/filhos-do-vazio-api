<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[Fillable([
    'name', 'slug', 'description', 'weight', 'quality', 'base_price', 'durability', 'is_consumable', 'type', 'image',
])]
class Item extends Model
{
    protected function casts(): array
    {
        return [
            'is_consumable' => 'boolean',
            'weight' => 'decimal:2',
        ];
    }

    public function modifiers(): MorphMany
    {
        return $this->morphMany(Modifier::class, 'target');
    }

    public function characters(): BelongsToMany
    {
        return $this->belongsToMany(Character::class, 'character_items')
            ->withPivot(['quantity', 'durability_remaining', 'is_equipped']);
    }

    public function equipmentPackages(): BelongsToMany
    {
        return $this->belongsToMany(EquipmentPackage::class, 'equipment_package_items')
            ->withPivot('quantity');
    }

    public function effects(): BelongsToMany
    {
        return $this->belongsToMany(Effect::class, 'item_effects');
    }
}
