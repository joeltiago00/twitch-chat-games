<?php

namespace Repositories\DuelAnswer;

use App\Models\Round;
use Game\Duel\DTO\DuelAnswerDTO;

class DuelAnswerEloquentRepository implements DuelAnswerRepository
{
    public function __construct(private readonly Round $model)
    {
    }

    public function store(DuelAnswerDTO $dto): Round
    {
        $round = $this->model
            ->newQuery()
            ->create($dto->toArray());

        /** @var Round */
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

    public function findById(int $id): Round
    {
        /** @var Round */
        return $this->model
            ->newQuery()
            ->findOrFail($id);
    }
}
