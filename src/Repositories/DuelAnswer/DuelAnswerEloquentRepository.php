<?php

namespace Repositories\DuelAnswer;

use App\Models\DuelAnswer;
use Game\Duel\DTO\DuelAnswerDTO;

class DuelAnswerEloquentRepository implements DuelAnswerRepository
{
    public function __construct(private readonly DuelAnswer $model)
    {
    }

    public function store(DuelAnswerDTO $dto): DuelAnswer
    {
        $round = $this->model
            ->newQuery()
            ->create($dto->toArray());

        /** @var DuelAnswer */
        return $round->load('duel');
    }

    public function existsByDuelIAndAnswerId(int $duelId, int $answerId): bool
    {
        return $this->model
            ->newQuery()
            ->where('duel_id', $duelId)
            ->where('answer_id', $answerId)
            ->exists();
    }

    public function getCountOfFinishedRoundByDuelId(int $duelId): int
    {
        return $this->model
            ->newQuery()
            ->where('duel_id', $duelId)
            ->whereNull('finished_at')
            ->count();
    }
}
