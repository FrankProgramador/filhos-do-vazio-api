<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        Role::findOrCreate('admin');

        $admin = User::where('email', 'test@example.com')->first();
        $admin?->assignRole('admin');
    }
}
