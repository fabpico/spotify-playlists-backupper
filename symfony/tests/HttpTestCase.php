<?php declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class HttpTestCase extends KernelTestCase
{
    private static HttpClientInterface $httpClient;

    public static function setUpBeforeClass(): void
    {
        static::$httpClient = new CurlHttpClient();
    }

    protected function request(string $method, string $url): ResponseInterface
    {
        $clientId = $_ENV['CLIENT_ID'];
        $clientSecret = $_ENV['CLIENT_SECRET'];
        $tokenResponse = static::$httpClient->request('POST',
            'https://accounts.spotify.com/api/token?grant_type=client_credentials',
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