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
            ->inRandomOrder()
            ->firstOrFail();
    }
}
