<?php

namespace Repositories\User;

use App\Models\User;
use Game\Auth\DTO\UserDTO;

class UserEloquentRepository implements UserRepository
{
    public function __construct(private readonly User $model)
    {
    }

    public function store(UserDTO $dto): User
    {
        /** @var User */
        return $this->model
            ->newQuery()
            ->create($dto->toArray());
    }

    public function findById(int $id): User
    {
        /** @var User */
        return $this->model
            ->newQuery()
            ->findOrFail($id);
    }

    public function findByExternalId(string $id): ?User
    {
        /** @var ?User */
        return $this->model
            ->newQuery()
            ->where('external_id', $id)
            ->first();
    }
}
