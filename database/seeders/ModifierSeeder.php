<?php

namespace Database\Seeders;

use App\Models\GameTrait;
use App\Models\Modifier;
use Illuminate\Database\Seeder;

class ModifierSeeder extends Seeder
{
    public function run(): void
    {
        foreach (GameTraitSeeder::definitions() as $definition) {
            $this->seedFor($definition['slug'], $definition['modifiers'] ?? []);

            foreach ($definition['subs'] ?? [] as $sub) {
                $this->seedFor($sub['slug'], $sub['modifiers'] ?? []);
            }
        }
    }

    private function seedFor(string $slug, array $modifiers): void
    {
        if ($modifiers === []) {
            return;
        }

        $trait = GameTrait::where('slug', $slug)->first();

        if (! $trait) {
            return;
        }

        foreach ($modifiers as $modifier) {
            Modifier::updateOrCreate(
                [
                    'target_type' => GameTrait::class,
                    'target_id' => $trait->id,
                    'attribute' => $modifier['attribute'],
                ],
                [
                    'operation' => $modifier['operation'],
                    'value' => $modifier['value'],
                ]
            );
        }
    }
}
