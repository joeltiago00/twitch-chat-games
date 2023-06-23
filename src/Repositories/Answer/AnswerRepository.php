<?php

namespace Repositories\Answer;

use App\Models\Answer;

interface AnswerRepository
{
    public function getRandomByType(int $typeId): Answer;

    public function getRandomOptions(string $except = '', int $quantity = 5): array;
}
