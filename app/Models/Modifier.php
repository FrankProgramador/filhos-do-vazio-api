<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable(['target_type', 'target_id', 'attribute', 'operation', 'value', 'description'])]
class Modifier extends Model
{
    protected function casts(): array
    {
        return [
            'value' => 'integer',
        ];
    }

    public function target(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Applies this modifier's operation to a current attribute value.
     */
    public static function apply(int $current, self $modifier): int
    {
        $value = (int) $modifier->value;

        return match ($modifier->operation) {
            'add' => $current + $value,
            'subtract' => $current - $value,
            'multiply' => $current * $value,
            'set' => $value,
        };
    }
}
