<?php

namespace TwitchIRC\Contracts;

interface TwitchIRCServiceInterface
{
    public function connect(): void;

    public function joinChannel(string $channel): void;

    public function read($size = 256): bool|string|null;

    public function send(string $message): bool|int|null;
}
