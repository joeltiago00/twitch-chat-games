<?php

namespace Game\Duel\Round;

use Game\Duel\PlayDuel;
use Illuminate\Support\Collection;
use Repositories\DuelAnswer\DuelAnswerRepository;

class PlayRound
{
    public function __construct(
        private readonly DuelAnswerRepository $duelAnswerRepository,
        private readonly PlayDuel $playDuel,
    )
    {
    }

    public function handle(int $roundId): Collection
    {
        $round = $this->duelAnswerRepository->findById($roundId);

        $roundScore = $this->playDuel->handle($round->duel, $round);

        return collect([
            'round_score' => $roundScore,
            'ranking' => $roundScore //TODO:: define ranking
        ]);
    }
}
