<?php

namespace Repositories\User;

use App\Models\User;
use Game\Auth\DTO\UserDTO;

interface UserRepository
{
    public function store(UserDTO $dto): User;

    public function findById(int $id): User;

    public function findByExternalId(string $id): ?User;
}
