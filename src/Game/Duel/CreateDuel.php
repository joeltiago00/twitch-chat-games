<?php

namespace Game\Duel;

use App\Models\Duel;
use App\Models\Type;
use Game\Duel\DTO\DuelDTO;
use Repositories\Duel\DuelRepository;

class CreateDuel
{
    public function __construct(private readonly DuelRepository $duelRepository)
    {
    }

    public function handle(array $data): Duel
    {
        return $this->duelRepository->store(new DuelDTO($data['chat'], $data['type_id']));
    }
}
