<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\ChatRoom;
use App\Models\Poem;
use App\Models\Book;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'first_name' => 'Test User',
            'last_name' => 'Example',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        // Seed poems and books
        $this->call([
            PoemSeeder::class,
            BookSeeder::class,
        ]);
    }
}
