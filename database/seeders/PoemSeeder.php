<?php

namespace Database\Seeders;

use App\Models\Poem;
use App\Models\User;
use Illuminate\Database\Seeder;

class PoemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create();

        $poems = [
            [
                'title' => 'Morning Light',
                'content' => 'Golden rays pierce through the trees,
Painting shadows on the morning breeze,
Each moment awakens to a new song,
Where the heart finds where it belongs.',
                'description' => 'A short poem about new beginnings',
                'author_id' => $user->id,
                'status' => 'published',
            ],
            [
                'title' => 'Silent Echoes',
                'content' => 'In the quiet of the night,
When the world is out of sight,
Echoes whisper ancient tales,
Of dreams that never fail.

Through the darkness, like a flame,
Hope returns without a name,
In silence we find our voice,
In stillness, we make our choice.',
                'description' => 'Reflections on silence and hope',
                'author_id' => $user->id,
                'status' => 'published',
            ],
            [
                'title' => 'City Streets',
                'content' => 'Concrete heartbeat, endless street,
Millions of voices in the heat,
Stories written on every wall,
The city whispers to us all.

Neon lights guide the way,
Through another endless day,
In this urban symphony we dance,
Lost within the trance.',
                'description' => 'Urban poetry about city life',
                'author_id' => $user->id,
                'status' => 'published',
            ],
            [
                'title' => 'Ocean\'s Call',
                'content' => 'Waves crash with eternal grace,
Salt upon my weathered face,
The ocean calls me back once more,
To walk along its endless shore.

In depths of blue, secrets sleep,
Mysteries the waters keep,
I answer to the siren\'s call,
The ocean owns us after all.',
                'description' => 'A meditation on the ocean',
                'author_id' => $user->id,
                'status' => 'published',
            ],
            [
                'title' => 'Autumn\'s Gold',
                'content' => 'Leaves dance in crimson fire,
Taking higher, ever higher,
Summer\'s green fades into gold,
Winter\'s story will be told.

In this season\'s sweet goodbye,
Beauty spreads across the sky,
Nature shows us how to change,
Through cycles sacred and estrange.',
                'description' => 'Seasonal reflections on change',
                'author_id' => $user->id,
                'status' => 'published',
            ],
            [
                'title' => 'Unspoken Words',
                'content' => 'There are words I cannot say,
Trapped inside from day to day,
Behind the smile and steel facade,
My heart whispers to the God.

You taught me how to feel and break,
How much more than I could take,
Yet here I stand, still holding on,
To memories of you, now gone.',
                'description' => 'A poem about unexpressed feelings',
                'author_id' => $user->id,
                'status' => 'published',
            ],
            [
                'title' => 'Starlight',
                'content' => 'Look up to find a million suns,
The night belongs to everyone,
Each star a wish, a dream, a prayer,
Scattered diamonds in the air.

We are small beneath their glow,
Yet infinite the things we know,
Connected to the vast expanse,
We are given just one chance.',
                'description' => 'Cosmic wonder and existence',
                'author_id' => $user->id,
                'status' => 'published',
            ],
            [
                'title' => 'Rain',
                'content' => 'Pitter-patter on the windowpane,
Cleansing earth of old stain,
Gray skies cry what we hold inside,
In the rain, we can confide.

Puddles form on empty streets,
Heartbeat matches rainfall\'s beat,
Wash away the pain and fear,
Let the rain make all things clear.',
                'description' => 'Rain as a metaphor for emotions',
                'author_id' => $user->id,
                'status' => 'published',
            ],
        ];

        foreach ($poems as $poem) {
            Poem::create($poem);
        }
    }
}
