<?php

return [
    'irc-oauth-token' => env('TWITCH_IRC_OAUTH_TOKEN'),
    'api' => [
        'client_id' => env('TWITCH_API_CLIENT_ID'),
        'client_secret' => env('TWITCH_API_CLIENT_SECRET'),
        'ttl_token' => env('TWITCH_API_TTL_TOKEN', 1200),
        'api_base_url' => env('TWITCH_API_BASE_URL', 'https://api.twitch.tv'),
        'auth_base_url' => env('TWITCH_API_AUTH_BASE_URL', 'https://id.twitch.tv'),
        'login_redirect_uri' => env('TWITCH_API_LOGIN_REDIRECT_URI')
    ]
];
