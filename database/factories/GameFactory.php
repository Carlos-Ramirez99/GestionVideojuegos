<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    protected $model = Game::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->sentence(3),
            'developer' => $this->faker->company,
            'distributor' => $this->faker->company,

            'release_year' => $this->faker->numberBetween(1990, 2025),

            'platform' => $this->faker->randomElement([
                'PC',
                'PlayStation 5',
                'Xbox Series X',
                'Nintendo Switch'
            ]),

            'genre' => $this->faker->randomElement([
                'Acción',
                'Aventura',
                'RPG',
                'Estrategia',
                'Deportes',
                'Shooter'
            ]),

            'description' => $this->faker->paragraphs(3, true),

            'game_mode' => $this->faker->randomElement([
                'Singleplayer',
                'Multiplayer',
                'Co-op'
            ]),

            //Imagen falsa
            'cover_image' => 'https://via.placeholder.com/300x400?text=Game',

            'classification' => $this->faker->randomElement([
                'E',
                'T',
                'M',
                'PEGI 7',
                'PEGI 12',
                'PEGI 18'
            ]),

            //Rating promedio
            'average_rating' => $this->faker->randomFloat(1, 0, 5),

            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
