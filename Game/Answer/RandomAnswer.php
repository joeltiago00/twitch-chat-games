<?php

namespace Game\Answer;

use App\Models\Answer;
use Repositories\Answer\AnswerRepository;
use Repositories\DuelAnswer\DuelAnswerRepository;

class RandomAnswer
{
    public function __construct(
        private readonly DuelAnswerRepository $duelAnswerRepository,
        private readonly AnswerRepository $answerRepository
    )
    {
    }

    public function handle(int $duelId, int $typeId): Answer
    {
        do {
            $answer = $this->answerRepository->getRandomByType($typeId);
        } while ($this->duelAnswerRepository->existsByDuelIAndAnswerId($duelId, $answer->getKey()));

        return $answer;
    }
}
