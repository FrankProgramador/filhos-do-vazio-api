<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public static function definitions(): array
    {
        return [
            ['slug' => 'ferrao', 'name' => 'Ferrão', 'description' => 'Uma arma básica e confiável.', 'weight' => 1, 'base_price' => 10, 'type' => 'weapon'],
            ['slug' => 'escudo-madeira', 'name' => 'Escudo de Madeira', 'description' => 'Um escudo leve e resistente.', 'weight' => 1, 'base_price' => 15, 'type' => 'shield'],
            ['slug' => 'racao', 'name' => 'Ração (1)', 'description' => 'Comida seca e nutritiva.', 'weight' => 0.5, 'base_price' => 5, 'type' => 'consumable', 'is_consumable' => true],
            ['slug' => 'corda', 'name' => 'Corda (10m)', 'description' => 'Útil para escalar e amarrar.', 'weight' => 1, 'base_price' => 8, 'type' => 'tool'],
            ['slug' => 'lamparina', 'name' => 'Lamparina', 'description' => 'Ilumina o caminho.', 'weight' => 1, 'base_price' => 12, 'type' => 'tool'],
            ['slug' => 'pocao-cura', 'name' => 'Poção de Cura', 'description' => 'Restaura 2 Corações.', 'weight' => 0.5, 'base_price' => 20, 'type' => 'consumable', 'is_consumable' => true],
            ['slug' => 'tacha', 'name' => 'Tacha', 'description' => 'Uma arma de arremesso leve.', 'weight' => 0.5, 'base_price' => 8, 'type' => 'weapon'],
            ['slug' => 'capa-camuflagem', 'name' => 'Capa de Camuflagem', 'description' => 'Concede +1 em Furtividade em terrenos naturais.', 'weight' => 1, 'base_price' => 15, 'type' => 'armor'],
            ['slug' => 'kit-reparo', 'name' => 'Kit de Reparo', 'description' => 'Restaura 1 Durabilidade de um item.', 'weight' => 0.5, 'base_price' => 10, 'type' => 'tool', 'is_consumable' => true],
        ];
    }

    public function run(): void
    {
        foreach (self::definitions() as $item) {
            Item::updateOrCreate(['slug' => $item['slug']], $item);
        }
    }
}
