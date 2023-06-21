<?php

namespace Database\Factories;

use App\Models\Duel;
use Illuminate\Database\Eloquent\Factories\Factory;

class DuelFactory extends Factory
{
    protected $model = Duel::class;

    public function definition(): array
    {
        return [
            'chat' => fake()->word(),
            'type_id' => 1
        ];
    }
}
