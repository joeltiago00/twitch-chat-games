<?php

namespace Game\Duel\DTO;

use Game\DTO\BaseDTO;

class DuelAnswerDTO extends BaseDTO
{
    public function __construct(
        public readonly int $duelId,
        public readonly int $answerId,
        public readonly int $answerNumber
    ){
    }
}
