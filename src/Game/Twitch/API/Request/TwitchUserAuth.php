<?php

namespace Game\Twitch\API\Request;

use Game\Twitch\API\Request\Client\TwitchApiClient;
use Game\Twitch\API\Request\Client\TwitchAuthClient;

class TwitchUserAuth
{
    private TwitchAuthClient $authClient;
    private TwitchApiClient $apiClient;

    public function __construct()
    {
        $this->authClient = new TwitchAuthClient(
            config('twitch.api.client_id'),
            config('twitch.api.client_secret')
        );

        $this->apiClient = new TwitchApiClient(
            config('twitch.api.client_id'),
            config('twitch.api.client_secret')
        );
    }

    public function handle(string $code): array
    {
        $response = $this->authClient->post('oauth2/token', [
            'client_id' => config('twitch.api.client_id'),
            'client_secret' => config('twitch.api.client_secret'),
            'code' => $code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => config('twitch.api.login_redirect_uri')]);

        $userData = $this->apiClient
            ->setToken($response['access_token'])
            ->get('helix/users');

        return $userData['data'][0];
    }
}
