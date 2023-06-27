<?php

namespace Repositories\DuelAnswer;

use App\Models\Round;
use Game\Duel\DTO\DuelAnswerDTO;

interface DuelAnswerRepository
{
    public function store(DuelAnswerDTO $dto): Round;

    public function existsByDuelIAndAnswerId(int $duelId, int $answerId): bool;

    public function getCountOfFinishedRoundByDuelId(int $duelId): int;

    public function findById(int $id): Round;
}
