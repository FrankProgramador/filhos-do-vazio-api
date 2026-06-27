<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'arena_match_id', 'user_id', 'character_id', 'label', 'color',
    'col', 'row', 'movement', 'movement_used', 'hp', 'max_hp', 'casca_atual', 'attacked',
])]
class ArenaMatchToken extends Model
{
    public function match(): BelongsTo
    {
        return $this->belongsTo(ArenaMatch::class, 'arena_match_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }

    protected function casts(): array
    {
        return [
            'attacked' => 'boolean',
        ];
    }
}
