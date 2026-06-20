<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    public function run(): void
    {
        $sizes = [
            [
                'slug' => 'pequeno',
                'name' => 'Pequeno',
                'description' => 'Ágil e rápido, mas frágil.',
                'image' => 'pequeno',
                'order' => 1,
                'poder' => 2, 'saber' => 3, 'casca' => 3, 'graca' => 4,
                'coracao' => 6, 'estamina' => 3, 'alma' => 3, 'velocidade' => 7,
                'fofo' => 1.5, 'assustador' => 1,
                'sustento_inicial' => 0, 'sustento_maximo' => 1,
            ],
            [
                'slug' => 'medio',
                'name' => 'Médio',
                'description' => 'Equilíbrio entre força e agilidade.',
                'image' => 'medio',
                'order' => 2,
                'poder' => 3, 'saber' => 3, 'casca' => 3, 'graca' => 3,
                'coracao' => 7, 'estamina' => 3, 'alma' => 3, 'velocidade' => 6,
                'fofo' => 1, 'assustador' => 1.5,
                'sustento_inicial' => 0, 'sustento_maximo' => 2,
            ],
            [
                'slug' => 'grande',
                'name' => 'Grande',
                'description' => 'Lento e resistente, causa medo.',
                'image' => 'grande',
                'order' => 3,
                'poder' => 4, 'saber' => 3, 'casca' => 4, 'graca' => 2,
                'coracao' => 8, 'estamina' => 3, 'alma' => 3, 'velocidade' => 5,
                'fofo' => 1, 'assustador' => 1.5,
                'sustento_inicial' => 0, 'sustento_maximo' => 3,
            ],
        ];

        foreach ($sizes as $size) {
            Size::updateOrCreate(['slug' => $size['slug']], $size);
        }
    }
}
