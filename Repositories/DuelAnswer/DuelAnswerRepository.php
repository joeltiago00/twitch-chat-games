<?php

namespace Repositories\DuelAnswer;

use App\Models\DuelAnswer;
use Game\Duel\DTO\DuelAnswerDTO;

interface DuelAnswerRepository
{
    public function store(DuelAnswerDTO $dto): DuelAnswer;

    public function existsByDuelIAndAnswerId(int $duelId, int $answerId): bool;
}
