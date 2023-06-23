<?php

namespace Game\Twitch\API\Request\Client;

use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

abstract class TwitchClient
{
    protected string $oAuthToken;
    protected string $clientId;
    protected string $clientSecret;
    protected string $baseUrl;
    protected array $headers;

    /**
     * @throws RequestException
     */
    public function get(string $uri): array
    {
        $response = Http::withHeaders($this->headers)
            ->get(sprintf('%s/%s', $this->baseUrl, $uri));

        $this->checkErrors($response);

        return $response->json();
    }

    /**
     * @throws RequestException
     */
    public function post(string $uri, array $data): array
    {
        $response = Http::withHeaders($this->headers)
            ->post(
                sprintf('%s/%s', $this->baseUrl, $uri),
                $data
            );

        $this->checkErrors($response);

        return $response->json();
    }

    public function setToken(string $token = ''): self
    {
        $this->oAuthToken = empty($token)
            ? Cache::remember(
                sprintf('twitch_oauth_%s', $this->clientId),
                config('twitch.api.ttl_token'),
                fn() => $this->makeAuth()
            )
            : $token;

        $this->setHeaders();

        return $this;
    }

    /**
     * @throws RequestException
     */
    protected function checkErrors(Response $response): void
    {
        if ($response->serverError() || $response->clientError()) {
            $response->throw();
        }
    }

    protected function setHeaders(): void
    {
        $this->headers = [
            'Authorization' => sprintf('Bearer %s', $this->oAuthToken),
            'Client-Id' => $this->clientId
        ];
    }

    public function addHeaders(array $headers): self
    {
        $this->headers = array_merge($this->headers, $headers);

        return $this;
    }

    public function clearHeaders(): self
    {
        $this->headers = [];

        return $this;
    }

    /**
     * @throws RequestException
     */
    protected function makeAuth(): string
    {
        $response = Http::post(sprintf('%s/oauth2/token', config('twitch.api.auth_base_url')), [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'client_credentials'
        ]);

        $this->checkErrors($response);

        return $response->json()['access_token'];
    }
}
