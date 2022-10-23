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
        $url = "https://api.spotify.com/v1/users/{$_ENV['SPOTIFY_USERNAME']}/playlists/$id/tracks";
        $data = $this->requestAuthenticated('GET', $url);
        $tracks = $data['items'];
        if ($data['total'] > $data['limit']) {
            $neededRequestsCount = (int)($data['total'] / $data['limit']);
            $offset = $data['limit'];
            for ($requestsCount = 1; $requestsCount <= $neededRequestsCount; $requestsCount++) {
                $nextData = $this->requestAuthenticated('GET', "$url?offset=$offset");
                $tracks = array_merge($tracks, $nextData['items']);
                $offset += $data['limit'];
            }
        }
        return $tracks;
    }

    private function requestAuthenticated(string $method, string $url): array
    {
        $accessToken = $this->cache->get('accessToken');
        $response = $this->httpClient->request($method, $url, [
            'headers' => ['Authorization' => "Bearer $accessToken"]
        ]);
        $data = json_decode($response->getContent(false), true);
        if (array_key_exists('error', $data)) {
            throw new \Exception(json_encode($data['error']));
        }
        return $data;
    }
}