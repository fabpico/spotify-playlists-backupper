<?php declare(strict_types=1);

namespace App\Common;

use Symfony\Contracts\HttpClient\HttpClientInterface;

final class Authorization
{
    private Cache $cache;
    private HttpClientInterface $httpClient;

    public function __construct(Cache $cache, HttpClientInterface $httpClient)
    {
        $this->cache = $cache;
        $this->httpClient = $httpClient;
    }

    public function cacheAccessToken(string $authorizationCode): void
    {
        $clientId = $_ENV['SPOTIFY_CLIENT_ID'];
        $clientSecret = $_ENV['SPOTIFY_CLIENT_SECRET'];
        $redirectUrl = $_ENV['SPOTIFY_REDIRECT_URL']; // required for endpoint, not for me
        $tokenResponse = $this->httpClient->request('POST',
            "https://accounts.spotify.com/api/token?grant_type=authorization_code&code=$authorizationCode&redirect_uri=$redirectUrl",
            [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode("$clientId:$clientSecret")
                ]
            ]
        );
        $tokenContent = json_decode($tokenResponse->getContent(false), true);
        $accessToken = $tokenContent['access_token'];
        $this->cache->save('accessToken', $accessToken);
    }
}