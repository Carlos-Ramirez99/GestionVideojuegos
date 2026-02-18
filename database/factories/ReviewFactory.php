<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'user_id' => 1, // se sobreescribe en el seeder
            'game_id' => 1, // se sobreescribe en el seeder
            'title'   => $this->faker->sentence(6), // ✅ obligatorio
            'content' => $this->faker->realText(450),
        ];
    }
}
