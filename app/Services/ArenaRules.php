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
        'unarmed' => ['label' => 'Desarmado', 'range' => 1, 'base_damage' => 1],
        'rock' => ['label' => 'Jogar pedra', 'range' => 6, 'base_damage' => 1],
    ];

    public const SUCCESS_THRESHOLD = 5;

    private const DIRECTIONS = [[-1, 0], [1, 0], [0, -1], [0, 1]];

    public static function isWall(int $col, int $row): bool
    {
        return $col === self::WALL_COL && $row >= 0 && $row < self::WALL_ROWS;
    }

    public static function manhattan(int $col1, int $row1, int $col2, int $row2): int
    {
        return abs($col1 - $col2) + abs($row1 - $row2);
    }

    /** Distância "de rei" (8 direções) — usada pra alcance de ataque, que pode acertar na diagonal. */
    public static function chebyshev(int $col1, int $row1, int $col2, int $row2): int
    {
        return max(abs($col1 - $col2), abs($row1 - $row2));
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

    /**
     * Rola `$count` d6. Cada dado 5 ou 6 é um sucesso — mesma regra de testes
     * gerais documentada em /como-jogar.
     *
     * @return array<int, int>
     */
    public static function rollDice(int $count): array
    {
        return array_map(fn () => random_int(1, 6), range(1, max(0, $count)));
    }

    /**
     * Resolve o dano de um ataque a partir dos dados já rolados:
     * - 0 sucessos = erro (sem dano, casca intacta).
     * - 1º sucesso aplica o dano base da opção de ataque; cada sucesso extra soma +1 — esse é o dano bruto.
     * - A casca do defensor funciona como um escudo que se desgasta: absorve o dano bruto até
     *   se esgotar; o que passar disso ("excedente") é o dano real, aplicado à vida.
     * - Acerto sempre causa pelo menos 1 de dano real, mesmo que a casca absorva tudo o resto.
     *
     * @param  array<int, int>  $rolls
     * @return array{successes: int, raw_damage: int, damage: int, hit: bool, remaining_casca: int}
     */
    public static function resolveDamage(array $rolls, int $baseDamage, int $defenderCasca): array
    {
        $successes = count(array_filter($rolls, fn (int $roll) => $roll >= self::SUCCESS_THRESHOLD));

        if ($successes === 0) {
            return ['successes' => 0, 'raw_damage' => 0, 'damage' => 0, 'hit' => false, 'remaining_casca' => $defenderCasca];
        }

        $rawDamage = $baseDamage + ($successes - 1);
        $cascaAbsorbed = min($rawDamage, $defenderCasca);
        $overflow = $rawDamage - $cascaAbsorbed;
        $damage = max(1, $overflow);

        return [
            'successes' => $successes,
            'raw_damage' => $rawDamage,
            'damage' => $damage,
            'hit' => true,
            'remaining_casca' => $defenderCasca - $cascaAbsorbed,
        ];
    }
}
