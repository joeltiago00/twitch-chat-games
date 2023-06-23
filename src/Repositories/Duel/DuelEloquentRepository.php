<?php

namespace Repositories\Duel;

use App\Models\Duel;
use Game\Duel\DTO\DuelDTO;

class DuelEloquentRepository implements DuelRepository
{
    public function __construct(private readonly Duel $model)
    {
    }

    public function store(DuelDTO $dto): Duel
    {
        /** @var Duel */
        return $this->model
            ->newQuery()
            ->create($dto->toArray());
    }

    public function findById(int $id): Duel
    {
        /** @var Duel */
        return $this->model
            ->newQuery()
            ->findOrFail($id);
    }

    public function isValidById(int $id): bool
    {
        return $this->model
            ->newQuery()
            ->where('id', $id)
            ->whereNull('finished_at')
            ->exists();
    }
}
