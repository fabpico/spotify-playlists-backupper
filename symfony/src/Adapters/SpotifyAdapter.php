<?php declare(strict_types=1);

namespace App\Adapters;

use App\Common\Cache;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class SpotifyAdapter
{
    private HttpClientInterface $httpClient;
    private Cache $cache;

    public function __construct(HttpClientInterface $httpClient, Cache $cache)
    {
        $this->httpClient = $httpClient;
        $this->cache = $cache;
    }

    public function getPlaylists(): array
    {
        $data = $this->requestAuthenticated('GET',
            "https://api.spotify.com/v1/users/{$_ENV['SPOTIFY_USERNAME']}/playlists?limit=50"
        );
        return $data['items'];
    }

    public function getPlaylistTracks(string $id): array
    {
        $data = $this->requestAuthenticated('GET',
            "https://api.spotify.com/v1/users/{$_ENV['SPOTIFY_USERNAME']}/playlists/$id/tracks"
        );
        return $data['items'];
    }

    private function requestAuthenticated(string $method, string $url): array
    {
        $accessToken = $this->cache->get('accessToken');
        $response = $this->httpClient->request($method, $url, [
            'headers' => ['Authorization' => "Bearer $accessToken"]
        ]);
        return json_decode($response->getContent(false), true);
    }
}