<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::pluck('id')->all();
        $games = Game::all();

        if (empty($users) || $games->isEmpty()) {
            return;
        }

        foreach ($games as $game) {
            //cuántas valoraciones tendrá este juego
            $numRatings = rand(3, min(20, count($users)));

            //selecciona usuarios únicos para evitar duplicados
            $pickedUsers = collect($users)->shuffle()->take($numRatings);

            foreach ($pickedUsers as $userId) {
                Rating::updateOrCreate(
                    [
                        'user_id' => $userId,
                        'game_id' => $game->id,
                    ],
                    [
                        'rating' => rand(1, 5),
                    ]
                );
            }

            //recalcular promedio en la tabla games
            $game->updateAverageRating();
        }
    }
}
