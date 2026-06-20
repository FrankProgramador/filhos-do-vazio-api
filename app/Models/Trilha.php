<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['slug', 'nome', 'tipo', 'thumb', 'nivel', 'beneficios', 'barra_aumentada', 'aumento'])]
class Trilha extends Model
{
    public function characters(): HasMany
    {
        return $this->hasMany(Character::class);
    }
}
