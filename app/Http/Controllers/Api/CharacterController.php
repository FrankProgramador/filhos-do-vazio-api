<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCharacterRequest;
use App\Models\Character;
use App\Models\GameTrait;
use App\Services\CharacterRuleValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CharacterController extends Controller
{
    private const RELATIONS = ['size', 'trilha', 'traits', 'items'];

    public function __construct(private CharacterRuleValidator $ruleValidator)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $characters = $request->user()->characters()->with(self::RELATIONS)->get();

        return response()->json($characters);
    }

    public function show(Request $request, Character $character): JsonResponse
    {
        $this->authorize('view', $character);

        return response()->json($character->load(self::RELATIONS));
    }

    public function store(StoreCharacterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $request->user();

        $result = $this->ruleValidator->validate($user, $data);

        $attributes = Character::calculateAttributes($result['size'], $result['traits']);
        $geoBudget = CharacterRuleValidator::STARTING_GEO + ($result['package']?->geo_bonus ?? 0);

        $character = DB::transaction(function () use ($data, $user, $result, $attributes, $geoBudget) {
            $character = Character::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'age' => $data['age'] ?? null,
                'species' => $data['species'] ?? null,
                'avatar' => $data['avatar'] ?? null,
                'size_id' => $result['size']->id,
                'trilha_id' => $result['trilha']->id,
                ...$attributes,
                'sustento' => $result['sustento'],
                'sustento_maximo' => $result['size']->sustento_maximo,
                'geo' => $geoBudget - $result['geoSpent'],
                'story' => $data['story'] ?? null,
                'appearance' => $data['appearance'] ?? null,
            ]);

            $personalityIds = array_map('intval', $data['personality_traits']);
            foreach ($result['traits'] as $trait) {
                $character->traits()->attach($trait->id, [
                    'quantity' => $trait->quantity,
                    'is_personality' => in_array($trait->id, $personalityIds, true),
                ]);
            }

            $itemQuantities = [];
            if ($result['package']) {
                foreach ($result['package']->items as $packageItem) {
                    $itemQuantities[$packageItem->id] = ($itemQuantities[$packageItem->id] ?? 0) + $packageItem->pivot->quantity;
                }
            }
            foreach ($result['purchasedItems'] as $item) {
                $itemQuantities[$item->id] = ($itemQuantities[$item->id] ?? 0) + $item->quantity;
            }
            foreach ($itemQuantities as $itemId => $quantity) {
                $character->items()->attach($itemId, ['quantity' => $quantity]);
            }

            return $character;
        });

        return response()->json($character->load(self::RELATIONS), 201);
    }

    public function update(Request $request, Character $character): JsonResponse
    {
        $this->authorize('update', $character);

        $data = $request->validate([
            'geo' => ['sometimes', 'integer', 'min:0'],
            'xp' => ['sometimes', 'integer', 'min:0'],
            'level' => ['sometimes', 'integer', 'min:1'],
            'story' => ['sometimes', 'nullable', 'string'],
            'appearance' => ['sometimes', 'nullable', 'string'],
        ]);

        $character->update($data);

        return response()->json($character->load(self::RELATIONS));
    }

    public function destroy(Request $request, Character $character): JsonResponse
    {
        $this->authorize('delete', $character);

        $character->delete();

        return response()->json(['message' => 'Personagem excluído.']);
    }

    /**
     * Concede um traço extra ganho em campanha (is_extra=true) — não conta para os
     * limites de criação e não permite reabrir as escolhas feitas na criação.
     */
    public function addTrait(Request $request, Character $character): JsonResponse
    {
        $this->authorize('update', $character);

        $data = $request->validate([
            'trait_id' => ['required', 'integer', 'exists:traits,id'],
            'quantity' => ['sometimes', 'integer', 'min:1'],
        ]);

        $character->traits()->attach($data['trait_id'], [
            'quantity' => $data['quantity'] ?? 1,
            'is_extra' => true,
        ]);

        return response()->json($character->load(self::RELATIONS));
    }

    /**
     * Troca um traço de personalidade por outro, mantendo sempre o total em 2.
     * Justificativa: eventos narrativos (trauma, crescimento) podem mudar a
     * personalidade do personagem durante a campanha.
     */
    public function swapPersonality(Request $request, Character $character): JsonResponse
    {
        $this->authorize('update', $character);

        $data = $request->validate([
            'old_trait_id' => ['required', 'integer', 'exists:traits,id'],
            'new_trait_id' => ['required', 'integer', 'exists:traits,id'],
        ]);

        $hasOld = $character->traits()->wherePivot('is_personality', true)->where('traits.id', $data['old_trait_id'])->exists();
        if (! $hasOld) {
            throw ValidationException::withMessages([
                'old_trait_id' => ['Este personagem não possui esse traço de personalidade.'],
            ]);
        }

        $newTrait = GameTrait::find($data['new_trait_id']);
        if (! $newTrait || $newTrait->rarity !== 'personality') {
            throw ValidationException::withMessages([
                'new_trait_id' => ['O novo traço precisa ser um traço de personalidade.'],
            ]);
        }

        DB::transaction(function () use ($character, $data, $newTrait) {
            $character->traits()->detach($data['old_trait_id']);
            $character->traits()->attach($newTrait->id, ['quantity' => 1, 'is_personality' => true]);
        });

        return response()->json($character->load(self::RELATIONS));
    }

    /**
     * Concede/compra um item adicional em campanha (loot, recompensa, etc.).
     */
    public function addItem(Request $request, Character $character): JsonResponse
    {
        $this->authorize('update', $character);

        $data = $request->validate([
            'item_id' => ['required', 'integer', 'exists:items,id'],
            'quantity' => ['sometimes', 'integer', 'min:1'],
        ]);

        $character->items()->attach($data['item_id'], [
            'quantity' => $data['quantity'] ?? 1,
        ]);

        return response()->json($character->load(self::RELATIONS));
    }
}
