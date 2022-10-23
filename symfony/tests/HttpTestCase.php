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
        $accessToken = static::$cache->get('accessToken');
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