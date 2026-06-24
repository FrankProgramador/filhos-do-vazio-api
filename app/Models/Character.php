<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

#[Fillable([
    'user_id', 'name', 'age', 'species', 'avatar', 'size_id', 'trilha_id',
    'poder', 'saber', 'casca', 'graca', 'coracao', 'estamina', 'alma', 'velocidade', 'fofo', 'assustador',
    'sustento', 'sustento_maximo', 'geo', 'xp', 'level', 'story', 'appearance',
])]
class Character extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class);
    }

    public function trilha(): BelongsTo
    {
        return $this->belongsTo(Trilha::class);
    }

    public function traits(): BelongsToMany
    {
        return $this->belongsToMany(GameTrait::class, 'character_traits', 'character_id', 'trait_id')
            ->withPivot(['quantity', 'is_inherent', 'is_personality', 'is_extra']);
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'character_items')
            ->withPivot(['quantity', 'durability_remaining', 'is_equipped']);
    }

    public function abilities(): BelongsToMany
    {
        return $this->belongsToMany(Ability::class, 'character_abilities')
            ->withPivot(['source_type', 'source_id', 'quantity', 'uses_remaining']);
    }

    /**
     * Mirrors the frontend's `atributos` useMemo in page.tsx: starts from the size's
     * absolute baseline, then applies each selected trait's Modifier rows multiplied
     * by the quantity picked. Deliberately does NOT fold in the trilha bonus — that
     * stays a display-only layer (see Summary.tsx's `finalAttrs`), matching the
     * frontend's existing separation between "build" attributes and "final" attributes.
     *
     * @param  Collection<int, GameTrait>  $selectedTraits  each trait must have a `pivot_quantity` or `quantity` accessor available
     */
    public static function calculateAttributes(Size $size, Collection $selectedTraits): array
    {
        $attributes = $size->baselineAttributes();

        foreach ($selectedTraits as $trait) {
            $quantity = $trait->pivot?->quantity ?? $trait->quantity ?? 1;

            foreach ($trait->modifiers as $modifier) {
                if (! array_key_exists($modifier->attribute, $attributes)) {
                    continue;
                }

                for ($i = 0; $i < $quantity; $i++) {
                    $attributes[$modifier->attribute] = Modifier::apply($attributes[$modifier->attribute], $modifier);
                }
            }
        }

        return $attributes;
    }

    /**
     * Sustento não é um orçamento gasto por traços — é só a Ração necessária por
     * descanso, fixa pelo tamanho do personagem. Traços são escolhidos livremente;
     * o balanceamento do jogo vem dos próprios atributos que cada traço altera.
     */
    public static function sustentoNecessario(Size $size): int
    {
        return $size->sustento_maximo;
    }

    /**
     * Mirrors `totalTracos` in page.tsx: sub-traços contam para o limite da sua própria
     * raridade (não há isenção); só traços ganhos pós-criação (is_extra) ficam de fora.
     * Multi-pick traits (max_selections > 1, e.g. "Poderoso") count once per quantity picked,
     * exactly like the frontend's `Object.values(attrTraits).reduce((a,b) => a+b, 0)`.
     *
     * @param  Collection<int, GameTrait>  $selectedTraits
     */
    public static function countCappedTraits(Collection $selectedTraits): int
    {
        return $selectedTraits
            ->filter(fn (GameTrait $trait) => ! ($trait->pivot?->is_extra ?? false))
            ->sum(fn (GameTrait $trait) => $trait->pivot?->quantity ?? $trait->quantity ?? 1);
    }
}
