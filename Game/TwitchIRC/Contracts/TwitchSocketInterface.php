<?php

namespace Game\TwitchIRC\Contracts;

interface TwitchSocketInterface
{
    public function connect();

    public function close(): void;

    public function isConnected(): bool;

    public function send(string $message): bool|int|null;

    public function read($size): bool|string|null;
}
