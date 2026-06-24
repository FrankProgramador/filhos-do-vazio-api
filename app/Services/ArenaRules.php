<?php

namespace App\Services;

use App\Models\ArenaMatchToken;
use Illuminate\Support\Collection;

/**
 * Mirrors the grid/movement/attack rules in the frontend's Arena.tsx (COLS, ROWS,
 * wall layout, orthogonal-only movement). Server-side so a match's authoritative
 * state can validate every move/attack the same way the client previews it.
 */
class ArenaRules
{
    public const COLS = 20;

    public const ROWS = 14;

    public const WALL_COL = 9;

    public const WALL_ROWS = 11; // rows 0..10

    public const ATTACK_OPTIONS = [
        'unarmed' => ['label' => 'Desarmado', 'range' => 1],
        'rock' => ['label' => 'Jogar pedra', 'range' => 6],
    ];

    private const DIRECTIONS = [[-1, 0], [1, 0], [0, -1], [0, 1]];

    public static function isWall(int $col, int $row): bool
    {
        return $col === self::WALL_COL && $row >= 0 && $row < self::WALL_ROWS;
    }

    public static function manhattan(int $col1, int $row1, int $col2, int $row2): int
    {
        return abs($col1 - $col2) + abs($row1 - $row2);
    }

    /**
     * @param  Collection<int, ArenaMatchToken>  $tokens
     */
    public static function isWalkable(Collection $tokens, int $ignoreTokenId, int $col, int $row): bool
    {
        if ($col < 0 || $row < 0 || $col >= self::COLS || $row >= self::ROWS) {
            return false;
        }

        if (self::isWall($col, $row)) {
            return false;
        }

        return ! $tokens->contains(fn (ArenaMatchToken $t) => $t->id !== $ignoreTokenId && $t->col === $col && $t->row === $row);
    }

    /**
     * BFS over the orthogonal grid. Returns ['col,row' => distance] for every
     * cell reachable within $maxRange steps, respecting walls and other tokens.
     *
     * @param  Collection<int, ArenaMatchToken>  $tokens
     * @return array<string, int>
     */
    public static function computeReachable(Collection $tokens, ArenaMatchToken $token, int $maxRange): array
    {
        $startKey = "{$token->col},{$token->row}";
        $dist = [$startKey => 0];
        $queue = [[$token->col, $token->row]];

        while ($queue !== []) {
            [$c, $r] = array_shift($queue);
            $d = $dist["{$c},{$r}"];
            if ($d >= $maxRange) {
                continue;
            }

            foreach (self::DIRECTIONS as [$dc, $dr]) {
                $nc = $c + $dc;
                $nr = $r + $dr;
                $key = "{$nc},{$nr}";
                if (isset($dist[$key])) {
                    continue;
                }
                if (! self::isWalkable($tokens, $token->id, $nc, $nr)) {
                    continue;
                }
                $dist[$key] = $d + 1;
                $queue[] = [$nc, $nr];
            }
        }

        return $dist;
    }
}
