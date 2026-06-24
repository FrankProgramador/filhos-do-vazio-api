<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[Fillable(['slug', 'nome', 'tipo', 'thumb', 'nivel', 'beneficios', 'barra_aumentada', 'aumento'])]
class Trilha extends Model
{
    public function characters(): HasMany
    {
        return $this->hasMany(Character::class);
    }

    public function abilitySources(): MorphMany
    {
        return $this->morphMany(AbilitySource::class, 'source');
    }
}
