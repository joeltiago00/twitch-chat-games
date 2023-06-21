<?php

namespace Database\Factories;

use App\Models\Answer;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerFactory extends Factory
{
    protected $model = Answer::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'type_id' => 1,
            'short_song_url' => fake()->url(),
            'medium_song_url' => fake()->url(),
            'large_song_url' => fake()->url(),
            'full_song_url' => fake()->url(),
            'is_active' => true
        ];
    }
}
