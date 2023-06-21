<?php

namespace Game\TwitchIRC;

use Game\TwitchIRC\Contracts\TwitchSocketInterface;

class TwitchIRCService extends TwitchIRC
{
    protected TwitchSocketInterface $twitchSocket;

    public function __construct(string $nick, string $oauth)
    {
        $this->nick = $nick;
        $this->oauth = $oauth;
        $this->twitchSocket = new TwitchSocket();
    }

    public function joinChannel(string $channel): void
    {
        $this->twitchSocket->send(sprintf('JOIN #%s', $this->nick));
    }

    public function read($size = 256): bool|string|null
    {
        return $this->twitchSocket->read($size);
    }

    public function send(string $message): bool|int|null
    {
        return $this->twitchSocket->send($message);
    }

    public function close(): void
    {
        $this->twitchSocket->close();
    }
}
