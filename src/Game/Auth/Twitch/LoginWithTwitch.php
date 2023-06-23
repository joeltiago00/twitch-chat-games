<?php

namespace Game\Auth\Twitch;


use App\Models\User;
use Game\Auth\DTO\UserDTO;
use Game\Twitch\API\Request\TwitchUserAuth;
use Repositories\User\UserRepository;

class LoginWithTwitch
{
    public function __construct(
        private readonly TwitchUserAuth $twitchAuth,
        private readonly UserRepository $userRepository
    )
    {
    }

    public function handle(string $code): User
    {
        $userData = $this->twitchAuth
            ->handle($code);

        if (!$user = $this->userRepository->findByExternalId($userData['id'])) {
            $user = $this->createUser($userData);
        }

        // TODO:: Create user session

        return $user;
    }

    private function createUser(array $userData): User
    {
        return $this->userRepository
            ->store(UserDTO::makeFromTwitchArray($userData));
    }
}
