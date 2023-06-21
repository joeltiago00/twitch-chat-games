<?php

namespace Repositories\Answer;

use App\Models\Answer;

interface AnswerRepository
{
    public function getRandomByType(int $typeId): Answer;
}
