<?php

namespace Game\TwitchIRC;

use Game\TwitchIRC\Contracts\TwitchIRCServiceInterface;
use Game\TwitchIRC\Contracts\TwitchSocketInterface;

abstract class TwitchIRC implements TwitchIRCServiceInterface
{
    protected string $nick;
    protected string $oauth;
    protected TwitchSocketInterface $twitchSocket;

    public function connect(): void
    {
        $this->twitchSocket->connect();

        // Authenticate
        $this->twitchSocket->send(sprintf('PASS %s', $this->oauth));

        // Set nick
        $this->twitchSocket->send(sprintf('NICK %s', $this->nick));

        $this->joinChannel($this->nick);
    }
}
