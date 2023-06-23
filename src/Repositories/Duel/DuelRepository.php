<?php

namespace Repositories\Duel;

use App\Models\Duel;
use Game\Duel\DTO\DuelDTO;

interface DuelRepository
{
    public function store(DuelDTO $dto): Duel;

    public function findById(int $id): Duel;

    public function isValidById(int $id): bool;
}
