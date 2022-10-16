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
        return static::$httpClient->request($method, $url);
    }

    protected function assertOkResponse(Response $response): void
    {
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}