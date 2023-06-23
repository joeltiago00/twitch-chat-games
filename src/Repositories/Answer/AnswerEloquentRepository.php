<?php

namespace Repositories\Answer;

use App\Models\Answer;

class AnswerEloquentRepository implements AnswerRepository
{
    public function __construct(private readonly Answer $model)
    {
    }

    public function getRandomByType(int $typeId): Answer
    {
        /** @var Answer */
        return $this->model
            ->newQuery()
            ->where('is_active', true)
            ->inRandomOrder()
            ->firstOrFail();
    }

    public function getRandomOptions(string $except = '', int $quantity = 5): array
    {
        return $this->model
            ->newQuery()
            ->where('is_active', true)
            ->inRandomOrder()
            ->whereNot('name', $except)
            ->limit($quantity)
            ->get()
            ->pluck('name')
            ->toArray();
    }
}
