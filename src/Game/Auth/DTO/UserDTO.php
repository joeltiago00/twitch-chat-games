<?php

namespace Game\Auth\DTO;

use Game\DTO\BaseDTO;

class UserDTO extends BaseDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $channel = '',
        public readonly string $externalId = '',
        public readonly string $password = ''
    )
    {
    }

    public static function makeFromTwitchArray(array $data): self
    {
        return new self(
            $data['display_name'],
            $data['email'],
            $data['login'],
            $data['id']
        );
    }
}
