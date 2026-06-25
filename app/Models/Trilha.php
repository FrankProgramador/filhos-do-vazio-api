<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    /**
     * Habilidades concedidas por esta trilha, por nível — reaproveita a tabela
     * `ability_sources` (mesma fonte que CharacterController usa para conceder
     * habilidades) como pivot, em vez de uma tabela nova.
     */
    public function abilities(): BelongsToMany
    {
        return $this->belongsToMany(Ability::class, 'ability_sources', 'source_id', 'ability_id')
            ->wherePivot('source_type', self::class)
            ->withPivot('level')
            ->orderByPivot('level');
    }
}
