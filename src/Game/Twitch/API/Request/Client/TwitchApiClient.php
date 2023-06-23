<?php

namespace Game\Twitch\API\Request\Client;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class TwitchApiClient extends TwitchClient
{
    public function __construct(
        protected string $clientId,
        protected string $clientSecret
    )
    {
        $this->setToken();
        $this->setHeaders();
        $this->baseUrl = config('twitch.api.api_base_url');
    }

}
