<?php

namespace Game\Duel\Round;

use App\Models\DuelAnswer;
use Game\Answer\RandomAnswer;
use Game\Duel\DTO\DuelAnswerDTO;
use Repositories\Duel\DuelRepository;
use Repositories\DuelAnswer\DuelAnswerRepository;

class CreateNewRound
{
    public function __construct(
        private readonly DuelRepository       $duelRepository,
        private readonly DuelAnswerRepository $duelAnswerRepository,
        private readonly RandomAnswer         $randomAnswer
    )
    {
    }

    public function handle(int $duelId): DuelAnswer
    {
        $duel = $this->duelRepository->findById($duelId);

        $answer = $this->randomAnswer->handle($duelId, $duel->type_id);

        return $this->duelAnswerRepository
            ->store(new DuelAnswerDTO($duelId, $answer->getKey(), rand(1, 6)));
    }
}
