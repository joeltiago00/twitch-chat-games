<?php

namespace Database\Factories;

use App\Models\Round;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoundFactory extends Factory
{
    protected $model = Round::class;

    public function definition(): array
    {
        return [
            'duel_id' => 1,
            'answer_id' => 1,
            'answer_number' => 1
        ];
    }
}
