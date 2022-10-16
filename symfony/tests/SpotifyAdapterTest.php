<?php declare(strict_types=1);

namespace App\Tests;

use App\Tests\Api\ApiTestCase;

final class SpotifyAdapterTest extends HttpTestCase
{
    public function testGetPlaylists(): void
    {
        $userId = $_ENV['USER_ID'] ?? 0; //todo
        $response = $this->request('GET', "https://api.spotify.com/v1/users/$userId/playlists");
        $this->assertOkResponse($response);
    }
}