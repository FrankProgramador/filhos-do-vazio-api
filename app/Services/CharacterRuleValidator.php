<?php

namespace App\Services;

use App\Models\EquipmentPackage;
use App\Models\GameTrait;
use App\Models\Item;
use App\Models\Size;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

/**
 * Validates the business rules for character creation that go beyond simple
 * field-level validation (FormRequest covers shape; this covers caps/budgets).
 */
class CharacterRuleValidator
{
    public const MAX_CHARACTERS_PER_USER = 3;

    public const MAX_COMMON_TRAITS = 7;

    public const MAX_REMARKABLE_TRAITS = 3;

    public const MAX_RARE_TRAITS = 1;

    public const REQUIRED_PERSONALITY_TRAITS = 2;

    public const STARTING_GEO = 50;

    /**
     * @return array{size: Size, trilha: \App\Models\Trilha, traits: Collection<int, GameTrait>, package: ?EquipmentPackage, purchasedItems: Collection<int, Item>, sustento: int, geoSpent: int}
     */
    public function validate(User $user, array $data): array
    {
        if ($user->characters()->count() >= self::MAX_CHARACTERS_PER_USER) {
            throw ValidationException::withMessages([
                'characters' => ['Você já atingiu o limite de '.self::MAX_CHARACTERS_PER_USER.' personagens.'],
            ]);
        }

        $size = Size::find($data['size_id']);
        $trilha = \App\Models\Trilha::find($data['trilha_id']);

        $attrTraitIds = array_keys($data['attr_traits'] ?? []);
        $specialTraitIds = $data['special_traits'] ?? [];
        $personalityTraitIds = $data['personality_traits'] ?? [];
        $subTraitIds = $data['sub_traits'] ?? [];

        $allSelectedIds = array_unique(array_merge($attrTraitIds, $specialTraitIds, $personalityTraitIds, $subTraitIds));

        $traitsById = GameTrait::with('modifiers')->whereIn('id', $allSelectedIds)->get()->keyBy('id');

        // Atribui a quantidade escolhida a cada traço selecionado (1 por padrão, N para traços de atributo).
        $traits = collect();
        foreach ($attrTraitIds as $id) {
            $trait = $traitsById->get((int) $id);
            if (! $trait) {
                continue;
            }
            $quantity = (int) ($data['attr_traits'][$id] ?? 1);
            if ($quantity > $trait->max_selections) {
                throw ValidationException::withMessages([
                    'attr_traits' => ["O traço \"{$trait->name}\" só pode ser escolhido até {$trait->max_selections} vez(es)."],
                ]);
            }
            $trait->quantity = $quantity;
            $traits->push($trait);
        }
        foreach (array_merge($specialTraitIds, $personalityTraitIds, $subTraitIds) as $id) {
            $trait = $traitsById->get((int) $id);
            if ($trait) {
                $trait->quantity = 1;
                $traits->push($trait);
            }
        }

        $this->validatePersonality($traits, $personalityTraitIds);
        $this->validateRarityCaps($traits);
        $this->validateSubTraitPrerequisites($traits, $subTraitIds, $allSelectedIds);

        // Sustento não é mais um orçamento gasto por traços — é a Ração necessária por
        // descanso, fixa pelo tamanho. Traços são livres dentro dos limites de raridade.
        $sustento = \App\Models\Character::sustentoNecessario($size);

        [$package, $purchasedItems, $geoSpent] = $this->validateEquipment($data);

        return [
            'size' => $size,
            'trilha' => $trilha,
            'traits' => $traits,
            'package' => $package,
            'purchasedItems' => $purchasedItems,
            'sustento' => $sustento,
            'geoSpent' => $geoSpent,
        ];
    }

    private function validatePersonality(Collection $traits, array $personalityTraitIds): void
    {
        if (count($personalityTraitIds) !== self::REQUIRED_PERSONALITY_TRAITS) {
            throw ValidationException::withMessages([
                'personality_traits' => ['Escolha exatamente '.self::REQUIRED_PERSONALITY_TRAITS.' traços de personalidade.'],
            ]);
        }

        $nonPersonality = $traits->whereIn('id', $personalityTraitIds)->where('rarity', '!=', 'personality');
        if ($nonPersonality->isNotEmpty()) {
            throw ValidationException::withMessages([
                'personality_traits' => ['Todos os traços escolhidos como personalidade devem ter raridade "personality".'],
            ]);
        }
    }

    private function validateRarityCaps(Collection $traits): void
    {
        // Pesa pela quantidade escolhida (traços de atributo multi-pick contam 1x por "vez"
        // escolhida), exatamente como o totalTracos do frontend. Sub-traços contam para o
        // limite da raridade que eles próprios têm (não há mais isenção para sub-traços).
        $weightedCountFor = fn (string $rarity) => $traits->where('rarity', $rarity)->sum(fn (GameTrait $t) => $t->quantity ?? 1);

        $commonCount = $weightedCountFor('common');
        $remarkableCount = $weightedCountFor('remarkable');
        $rareCount = $weightedCountFor('rare');

        if ($commonCount > self::MAX_COMMON_TRAITS) {
            throw ValidationException::withMessages([
                'special_traits' => ['Limite de '.self::MAX_COMMON_TRAITS.' traços comuns excedido.'],
            ]);
        }
        if ($remarkableCount > self::MAX_REMARKABLE_TRAITS) {
            throw ValidationException::withMessages([
                'special_traits' => ['Limite de '.self::MAX_REMARKABLE_TRAITS.' traços marcantes excedido.'],
            ]);
        }
        if ($rareCount > self::MAX_RARE_TRAITS) {
            throw ValidationException::withMessages([
                'special_traits' => ['Limite de '.self::MAX_RARE_TRAITS.' traço raro excedido.'],
            ]);
        }
    }

    private function validateSubTraitPrerequisites(Collection $traits, array $subTraitIds, array $allSelectedIds): void
    {
        foreach ($subTraitIds as $id) {
            $trait = $traits->firstWhere('id', (int) $id);
            if (! $trait || $trait->prerequisite_trait_id === null) {
                continue;
            }
            if (! in_array((string) $trait->prerequisite_trait_id, array_map('strval', $allSelectedIds), true)) {
                throw ValidationException::withMessages([
                    'sub_traits' => ["O traço \"{$trait->name}\" requer que seu traço base esteja selecionado."],
                ]);
            }
        }
    }

    /**
     * @return array{0: ?EquipmentPackage, 1: Collection<int, Item>, 2: int}
     */
    private function validateEquipment(array $data): array
    {
        $package = null;
        if (! empty($data['equipment_package_id'])) {
            $package = EquipmentPackage::find($data['equipment_package_id']);
        }

        $geoBudget = self::STARTING_GEO + ($package?->geo_bonus ?? 0);

        $purchasedItems = collect();
        $geoSpent = 0;
        foreach ($data['items'] ?? [] as $itemId => $quantity) {
            $item = Item::find($itemId);
            if (! $item) {
                continue;
            }
            $item->quantity = (int) $quantity;
            $geoSpent += $item->base_price * (int) $quantity;
            $purchasedItems->push($item);
        }

        if ($geoSpent > $geoBudget) {
            throw ValidationException::withMessages([
                'items' => ["Orçamento de Geo excedido: gasto de {$geoSpent}, disponível {$geoBudget}."],
            ]);
        }

        return [$package, $purchasedItems, $geoSpent];
    }
}
