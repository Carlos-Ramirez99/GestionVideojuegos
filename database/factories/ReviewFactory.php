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
            'user_id' => 1,
            'game_id' => 1,
            'title'   => $this->faker->sentence(6),
            'content' => $this->faker->realText(450),
        ];
    }
}
