<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create();

        $books = [
            [
                'title' => 'The Art of Poetry',
                'description' => 'A comprehensive guide to understanding and writing poetry. Explore different forms, styles, and techniques used by master poets throughout history.',
                'author_id' => $user->id,
                'status' => 'published',
            ],
            [
                'title' => 'Modern Verses',
                'description' => 'A collection of contemporary poems exploring themes of identity, love, loss, and hope in the modern world. Raw, honest, and deeply personal.',
                'author_id' => $user->id,
                'status' => 'published',
            ],
            [
                'title' => 'Whispers of the Soul',
                'description' => 'Poetic reflections on the human experience, nature, and spirituality. Each poem is a window into the depths of the author\'s introspection.',
                'author_id' => $user->id,
                'status' => 'published',
            ],
            [
                'title' => 'Urban Dreams',
                'description' => 'Poetry inspired by city life, street culture, and the rhythm of urban existence. Vivid imagery brings the concrete jungle to life.',
                'author_id' => $user->id,
                'status' => 'published',
            ],
            [
                'title' => 'Echoes of Yesterday',
                'description' => 'A nostalgic journey through memories, moments, and the passage of time. These poems capture the bittersweet essence of looking back.',
                'author_id' => $user->id,
                'status' => 'published',
            ],
            [
                'title' => 'Midnight Musings',
                'description' => 'Late-night thoughts transformed into poetry. Dark, introspective, and beautifully melancholic pieces that resonate with the night owl soul.',
                'author_id' => $user->id,
                'status' => 'published',
            ],
            [
                'title' => 'Nature\'s Song',
                'description' => 'Celebrating the beauty and power of nature through verse. From mountains to oceans, forests to deserts, nature inspires these flowing poems.',
                'author_id' => $user->id,
                'status' => 'published',
            ],
            [
                'title' => 'Love in Words',
                'description' => 'An exploration of love in all its forms—romantic, familial, platonic, and self-love. Each poem is a testament to human connection.',
                'author_id' => $user->id,
                'status' => 'published',
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
