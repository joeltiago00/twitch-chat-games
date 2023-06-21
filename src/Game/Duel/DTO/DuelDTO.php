<?php

namespace Game\Duel\DTO;

use Game\DTO\BaseDTO;

class DuelDTO extends BaseDTO
{
    public function __construct(public readonly string $chat)
    {
    }
}
