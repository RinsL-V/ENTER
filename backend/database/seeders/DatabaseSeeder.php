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
        // Демо-администратор: admin@enter.ru / admin123
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@enter.ru',
            'password' => 'admin123',
            'role' => 'admin',
        ]);

        // Демо-пользователь: user@enter.ru / user1234
        User::factory()->create([
            'name' => 'Demo User',
            'email' => 'user@enter.ru',
            'password' => 'user1234',
        ]);

        $this->call([
            ChapterSeeder::class,
        ]);
    }
}
