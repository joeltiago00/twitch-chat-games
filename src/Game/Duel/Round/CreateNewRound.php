<?php

namespace Game\Duel\Round;

use App\Models\Round;
use Game\Answer\RandomAnswer;
use Game\Answer\RandomOption;
use Game\Duel\DTO\DuelAnswerDTO;
use Repositories\Duel\DuelRepository;
use Repositories\DuelAnswer\DuelAnswerRepository;

class CreateNewRound
{
    public function __construct(
        private readonly DuelRepository       $duelRepository,
        private readonly DuelAnswerRepository $duelAnswerRepository,
        private readonly RandomAnswer         $randomAnswer,
        private readonly RandomOption         $randomOption
    )
    {
    }

    public function handle(int $duelId): Round
    {
        $duel = $this->duelRepository->findById($duelId);

        $answer = $this->randomAnswer->handle($duelId, $duel->type_id);

        $round = $this->duelAnswerRepository
            ->store(new DuelAnswerDTO($duelId, $answer->getKey(), rand(1, 6)));

        $options = $this->randomOption->handle($answer->name, 5);
        $options[] = $answer->name;

        shuffle($options);

        $round->options = $options;

        return $round;
    }
}
