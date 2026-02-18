<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::pluck('id')->all();
        $games = Game::all();

        if (empty($users) || $games->isEmpty()) {
            return;
        }

        foreach ($games as $game) {
            // reseñas por juego (puedes ajustar)
            $numReviews = rand(0, 8);

            for ($i = 0; $i < $numReviews; $i++) {
                $userId = $users[array_rand($users)];

                Review::factory()->create([
                    'user_id' => $userId,
                    'game_id' => $game->id,
                    'title' => fake()->sentence(6),
                ]);
            }
        }
    }
}
