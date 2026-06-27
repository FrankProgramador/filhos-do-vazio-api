<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ArenaMatch;
use App\Models\ArenaMatchToken;
use App\Models\Character;
use App\Services\ArenaRules;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ArenaMatchController extends Controller
{
    private const RELATIONS = ['tokens'];

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate(['character_id' => ['required', 'integer']]);
        $character = $this->ownedCharacter($request, $data['character_id']);

        $match = DB::transaction(function () use ($request, $character) {
            $match = ArenaMatch::create(['status' => 'waiting', 'turn_number' => 1]);

            ArenaMatchToken::create([
                'arena_match_id' => $match->id,
                'user_id' => $request->user()->id,
                'character_id' => $character->id,
                'label' => mb_strtoupper(mb_substr($character->name, 0, 1)),
                'color' => '#b8924a',
                'col' => 4,
                'row' => 7,
                'movement' => 5,
                'hp' => 4,
                'max_hp' => 4,
                'casca_atual' => $character->casca,
            ]);

            return $match;
        });

        return response()->json($match->load(self::RELATIONS), 201);
    }

    public function join(Request $request, ArenaMatch $arenaMatch): JsonResponse
    {
        $data = $request->validate(['character_id' => ['required', 'integer']]);
        $character = $this->ownedCharacter($request, $data['character_id']);

        if ($arenaMatch->status !== 'waiting') {
            throw ValidationException::withMessages(['match' => 'Esta partida já começou ou foi encerrada.']);
        }

        if ($arenaMatch->tokens()->count() >= 2) {
            throw ValidationException::withMessages(['match' => 'Esta partida já está cheia.']);
        }

        if ($arenaMatch->tokens()->where('user_id', $request->user()->id)->exists()) {
            throw ValidationException::withMessages(['match' => 'Você já está nesta partida.']);
        }

        DB::transaction(function () use ($request, $arenaMatch, $character) {
            $token = ArenaMatchToken::create([
                'arena_match_id' => $arenaMatch->id,
                'user_id' => $request->user()->id,
                'character_id' => $character->id,
                'label' => mb_strtoupper(mb_substr($character->name, 0, 1)),
                'color' => '#a34a4a',
                'col' => 15,
                'row' => 7,
                'movement' => 5,
                'hp' => 4,
                'max_hp' => 4,
                'casca_atual' => $character->casca,
            ]);

            $firstToken = $arenaMatch->tokens()->orderBy('id')->first();
            $arenaMatch->update(['status' => 'active', 'current_token_id' => $firstToken->id]);
        });

        return response()->json($arenaMatch->refresh()->load(self::RELATIONS));
    }

    public function show(Request $request, ArenaMatch $arenaMatch): JsonResponse
    {
        return response()->json($arenaMatch->load(self::RELATIONS));
    }

    public function move(Request $request, ArenaMatch $arenaMatch): JsonResponse
    {
        $data = $request->validate([
            'token_id' => ['required', 'integer'],
            'col' => ['required', 'integer'],
            'row' => ['required', 'integer'],
        ]);

        $token = $this->myActiveToken($request, $arenaMatch, $data['token_id']);
        $tokens = $arenaMatch->tokens;
        $remaining = $token->movement - $token->movement_used;

        $reachable = ArenaRules::computeReachable($tokens, $token, max(0, $remaining));
        $key = "{$data['col']},{$data['row']}";

        if (! isset($reachable[$key]) || $reachable[$key] === 0) {
            throw ValidationException::withMessages(['destination' => 'Destino fora do alcance de movimento.']);
        }

        $token->update([
            'col' => $data['col'],
            'row' => $data['row'],
            'movement_used' => $token->movement_used + $reachable[$key],
        ]);

        return response()->json($arenaMatch->refresh()->load(self::RELATIONS));
    }

    public function attack(Request $request, ArenaMatch $arenaMatch): JsonResponse
    {
        $data = $request->validate([
            'token_id' => ['required', 'integer'],
            'target_token_id' => ['required', 'integer'],
            'option' => ['required', 'string', 'in:'.implode(',', array_keys(ArenaRules::ATTACK_OPTIONS))],
            'estamina_gasta' => ['required', 'integer', 'min:1'],
        ]);

        $token = $this->myActiveToken($request, $arenaMatch, $data['token_id']);
        $target = $arenaMatch->tokens->firstWhere('id', $data['target_token_id']);

        if (! $target || $target->id === $token->id) {
            throw ValidationException::withMessages(['target_token_id' => 'Alvo inválido.']);
        }

        if ($token->attacked) {
            throw ValidationException::withMessages(['token_id' => 'Você já atacou neste turno.']);
        }

        $range = ArenaRules::ATTACK_OPTIONS[$data['option']]['range'];
        if (ArenaRules::chebyshev($token->col, $token->row, $target->col, $target->row) > $range) {
            throw ValidationException::withMessages(['target_token_id' => 'Alvo fora de alcance.']);
        }

        $attacker = $token->character;

        if (! $attacker) {
            throw ValidationException::withMessages(['token_id' => 'Personagem do token não encontrado.']);
        }

        if ($data['estamina_gasta'] > $attacker->estamina) {
            throw ValidationException::withMessages(['estamina_gasta' => 'Você não tem estamina suficiente.']);
        }

        $diceCount = $data['estamina_gasta'] + $attacker->poder;
        $rolls = ArenaRules::rollDice($diceCount);
        $baseDamage = ArenaRules::ATTACK_OPTIONS[$data['option']]['base_damage'];
        $result = ArenaRules::resolveDamage($rolls, $baseDamage, $target->casca_atual);

        $token->update(['attacked' => true]);

        if ($result['hit']) {
            $target->update([
                'hp' => max(0, $target->hp - $result['damage']),
                'casca_atual' => $result['remaining_casca'],
            ]);

            if ($target->hp === 0) {
                $arenaMatch->update(['status' => 'finished', 'winner_token_id' => $token->id]);
            }
        }

        $matchData = $arenaMatch->refresh()->load(self::RELATIONS)->toArray();
        $matchData['attack_result'] = [
            'rolls' => $rolls,
            'successes' => $result['successes'],
            'hit' => $result['hit'],
            'damage' => $result['damage'],
            'remaining_casca' => $result['remaining_casca'],
        ];

        return response()->json($matchData);
    }

    public function endTurn(Request $request, ArenaMatch $arenaMatch): JsonResponse
    {
        $data = $request->validate(['token_id' => ['required', 'integer']]);
        $token = $this->myActiveToken($request, $arenaMatch, $data['token_id']);

        $other = $arenaMatch->tokens->firstWhere('id', '!=', $token->id);

        $token->update(['movement_used' => 0, 'attacked' => false]);
        $arenaMatch->update([
            'current_token_id' => $other?->id,
            'turn_number' => $arenaMatch->turn_number + 1,
        ]);

        return response()->json($arenaMatch->refresh()->load(self::RELATIONS));
    }

    private function ownedCharacter(Request $request, int $characterId): Character
    {
        $character = Character::where('user_id', $request->user()->id)->find($characterId);

        if (! $character) {
            throw ValidationException::withMessages(['character_id' => 'Personagem não encontrado.']);
        }

        return $character;
    }

    private function myActiveToken(Request $request, ArenaMatch $arenaMatch, int $tokenId): ArenaMatchToken
    {
        if ($arenaMatch->status !== 'active') {
            throw ValidationException::withMessages(['match' => 'Esta partida não está ativa.']);
        }

        $token = $arenaMatch->tokens->firstWhere('id', $tokenId);

        if (! $token || $token->user_id !== $request->user()->id) {
            throw ValidationException::withMessages(['token_id' => 'Este token não pertence a você.']);
        }

        if ($arenaMatch->current_token_id !== $token->id) {
            throw ValidationException::withMessages(['match' => 'Não é o seu turno.']);
        }

        return $token;
    }
}
