<?php

namespace Game\TwitchIRC;

use Game\TwitchIRC\Contracts\TwitchSocketInterface;
use Socket;

class TwitchSocket implements TwitchSocketInterface
{
    private ?Socket $socket;
    static string $host = "irc.chat.twitch.tv";
    static string $port = "6667";

    public function __construct()
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    }

    public function connect()
    {
        if (socket_connect($this->socket, self::$host, self::$port) === FALSE) {
            return null;
        }
    }

    public function close(): void
    {
        socket_close($this->socket);
    }

    public function isConnected(): bool
    {
        return !is_null($this->socket);
    }

    public function send(string $message): bool|int|null
    {
        if (!$this->isConnected()) {
            return null;
        }

        return socket_write($this->socket, $message . PHP_EOL);
    }

    public function read($size): bool|string|null
    {
        if (!$this->isConnected()) {
            return null;
        }

        return socket_read($this->socket, $size);
    }
}
