<?php

namespace Database\Factories;

use App\Models\Rating;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingFactory extends Factory
{
    protected $model = Rating::class;

    public function definition(): array
    {
        return [
            'user_id' => 1,     // se sobreescribe en el seeder
            'game_id' => 1,     // se sobreescribe en el seeder
            'rating'  => $this->faker->numberBetween(1, 5),
        ];
    }
}
