<?php declare(strict_types=1);

namespace App\Tests;

use App\Common\Cache;
use App\Kernel;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class HttpTestCase extends KernelTestCase
{
    private static HttpClientInterface $httpClient;
    private static Cache $cache;

    public static function setUpBeforeClass(): void
    {
        static::$httpClient = new CurlHttpClient();
        static::bootKernel();
        static::$cache = static::$kernel->getContainer()->get(Cache::class);
    }

    protected static function getKernelClass(): string
    {
        return Kernel::class;
    }

    protected function request(string $method, string $url): ResponseInterface
    {
        $clientId = $_ENV['SPOTIFY_CLIENT_ID'];
        $clientSecret = $_ENV['SPOTIFY_CLIENT_SECRET'];
        $redirectUrl = $_ENV['SPOTIFY_REDIRECT_URL']; // required for endpoint, not for test
        $code = static::$cache->get('code');

        $tokenResponse = static::$httpClient->request('POST',
            "https://accounts.spotify.com/api/token?grant_type=authorization_code&code=$code&redirect_uri=$redirectUrl",
            [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode("$clientId:$clientSecret")
                ]
            ]
        );
        $tokenContent = json_decode($tokenResponse->getContent(false), true);
        $accessToken = $tokenContent['access_token'];
        return static::$httpClient->request($method, $url, [
            'headers' => [
                'Authorization' => "Bearer $accessToken"
            ]
        ]);
    }

    protected function assertOkResponse(ResponseInterface $response): void
    {
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}