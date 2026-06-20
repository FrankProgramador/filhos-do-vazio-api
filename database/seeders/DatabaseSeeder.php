<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Usuário de teste só é criado em ambientes de desenvolvimento/staging —
        // evita quebrar o seed em produção (onde fakerphp/faker normalmente não
        // está instalado) e evita semear uma conta com senha conhecida lá.
        if (app()->environment(['local', 'staging', 'testing']) && ! User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        $this->call([
            RolesSeeder::class,
            SizeSeeder::class,
            TrilhaSeeder::class,
            GameTraitSeeder::class,
            ModifierSeeder::class,
            ItemSeeder::class,
            EquipmentPackageSeeder::class,
        ]);
    }
}
