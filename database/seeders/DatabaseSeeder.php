<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /* User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]); */

        // Llamando a los seeders individuales
        $this->call([
            CategoriesSeeder::class,
            ElementsSeeder::class,
            StatesSeeder::class,
            RolesAndPermissionsSeeder::class,
            UsersRolesSeeder::class,
            UsersSeeder::class

        ]);
    }
}
