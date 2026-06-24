<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable(['ability_id', 'source_type', 'source_id', 'level'])]
class AbilitySource extends Model
{
    public function ability(): BelongsTo
    {
        return $this->belongsTo(Ability::class);
    }

    public function source(): MorphTo
    {
        return $this->morphTo();
    }
}
