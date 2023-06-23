<?php

namespace Game\Answer;

use Repositories\Answer\AnswerRepository;

class RandomOption
{
    public function __construct(
        private readonly AnswerRepository $answerRepository
    )
    {
    }

    public function handle(string $rightAnswer, int $optionsQuantity): array
    {
        return $this->answerRepository->getRandomOptions($rightAnswer, $optionsQuantity);
    }
}
