<?php

namespace Database\Seeders;

use App\Models\EquipmentPackage;
use App\Models\Item;
use Illuminate\Database\Seeder;

class EquipmentPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'slug' => 'aventureiro',
                'name' => 'Aventureiro',
                'description' => 'Para quem busca combate e exploração.',
                'geo_bonus' => 0,
                'items' => ['ferrao' => 1, 'escudo-madeira' => 1, 'racao' => 3, 'corda' => 1, 'lamparina' => 1],
            ],
            [
                'slug' => 'viajante',
                'name' => 'Viajante',
                'description' => 'Para quem prefere agilidade e furtividade.',
                'geo_bonus' => 5,
                'items' => ['tacha' => 2, 'capa-camuflagem' => 1, 'racao' => 2, 'corda' => 1],
            ],
            [
                'slug' => 'estudioso',
                'name' => 'Estudioso',
                'description' => 'Para quem busca conhecimento e magia.',
                'geo_bonus' => 0,
                'items' => ['ferrao' => 1, 'racao' => 2, 'lamparina' => 1],
            ],
            [
                'slug' => 'forjador',
                'name' => 'Forjador',
                'description' => 'Para quem trabalha com ferramentas e reparos.',
                'geo_bonus' => 5,
                'items' => ['ferrao' => 1, 'kit-reparo' => 1, 'racao' => 2],
            ],
            [
                'slug' => 'errante',
                'name' => 'Errante',
                'description' => 'Para quem não tem origem definida.',
                'geo_bonus' => 10,
                'items' => ['ferrao' => 1, 'racao' => 2],
            ],
        ];

        foreach ($packages as $definition) {
            $items = $definition['items'];
            unset($definition['items']);

            $package = EquipmentPackage::updateOrCreate(['slug' => $definition['slug']], $definition);

            $attachments = [];
            foreach ($items as $itemSlug => $quantity) {
                $item = Item::where('slug', $itemSlug)->first();
                if ($item) {
                    $attachments[$item->id] = ['quantity' => $quantity];
                }
            }

            $package->items()->sync($attachments);
        }
    }
}
