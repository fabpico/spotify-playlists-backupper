<?php declare(strict_types=1);

namespace App\Tests;

use App\Tests\Api\ApiTestCase;
use PHPUnit\Framework\Assert;

final class SpotifyAdapterTest extends HttpTestCase
{
    public function testGetPlaylists(): void
    {
        $userId = $_ENV['USER_ID'];
        $response = $this->request('GET', "https://api.spotify.com/v1/users/$userId/playlists");

        $this->assertOkResponse($response);
        $data = json_decode($response->getContent(false), true);
        Assert::assertNotEmpty($data['items'], 'No playlists received.');
    }
}