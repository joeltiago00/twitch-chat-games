<?php

namespace Database\Factories;

use App\Models\DuelAnswer;
use Illuminate\Database\Eloquent\Factories\Factory;

class DuelAnswerFactory extends Factory
{
    protected $model = DuelAnswer::class;

    public function definition(): array
    {
        return [
            'duel_id' => 1,
            'answer_id' => 1,
            'answer_number' => 1
        ];
    }
}
