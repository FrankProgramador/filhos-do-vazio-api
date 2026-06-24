<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['status', 'turn_number', 'current_token_id', 'winner_token_id'])]
class ArenaMatch extends Model
{
    public function tokens(): HasMany
    {
        return $this->hasMany(ArenaMatchToken::class);
    }
}
