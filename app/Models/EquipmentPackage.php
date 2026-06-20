<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['name', 'slug', 'description', 'geo_bonus', 'image'])]
class EquipmentPackage extends Model
{
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'equipment_package_items')
            ->withPivot('quantity');
    }
}
