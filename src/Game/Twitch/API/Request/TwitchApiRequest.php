<?php

namespace Game\Twitch\API\Request;

use Game\Twitch\API\Request\Client\TwitchApiClient;

class TwitchApiRequest
{
    private TwitchApiClient $apiClient;

    public function __construct(TwitchApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function getMe(): array
    {
        return $this->apiClient->get('helix/users');
    }


//    private function arrayToUrl(array $array, string $type): string
//    {
//        $url = '';
//
//        collect($array)->each(function ($data) use ($url, $type) {
//            $url .= sprintf('%s=%s', $type, $data);
//        });
//
//        return $url;
//    }
}
