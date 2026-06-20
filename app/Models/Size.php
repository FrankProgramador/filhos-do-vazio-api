<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'slug', 'name', 'description', 'image',
    'poder', 'saber', 'casca', 'graca', 'coracao', 'estamina', 'alma', 'velocidade', 'fofo', 'assustador',
    'sustento_inicial', 'sustento_maximo', 'order',
])]
class Size extends Model
{
    public const ATTRIBUTES = [
        'poder', 'saber', 'casca', 'graca', 'coracao', 'estamina', 'alma', 'velocidade', 'fofo', 'assustador',
    ];

    protected function casts(): array
    {
        return [
            'poder' => 'decimal:1',
            'saber' => 'decimal:1',
            'casca' => 'decimal:1',
            'graca' => 'decimal:1',
            'coracao' => 'decimal:1',
            'estamina' => 'decimal:1',
            'alma' => 'decimal:1',
            'velocidade' => 'decimal:1',
            'fofo' => 'decimal:1',
            'assustador' => 'decimal:1',
        ];
    }

    public function characters(): HasMany
    {
        return $this->hasMany(Character::class);
    }

    /**
     * Returns this size's baseline attribute block as a plain attribute => value array.
     */
    public function baselineAttributes(): array
    {
        return collect(self::ATTRIBUTES)
            ->mapWithKeys(fn (string $attribute) => [$attribute => (float) $this->{$attribute}])
            ->all();
    }
}
