<?php declare(strict_types=1);

namespace App\Tests;

use App\Adapters\SpotifyAdapter;
use App\Tests\Api\ApiTestCase;
use PHPUnit\Framework\Assert;

final class SpotifyAdapterTest extends IntegrationTestCase
{
    private SpotifyAdapter $spotifyAdapter;

    public function setUp(): void
    {
        $this->spotifyAdapter = static::$kernel->getContainer()->get(SpotifyAdapter::class);
    }

    public function testGetPlaylists(): void
    {
        $playlists = $this->spotifyAdapter->getPlaylists();
        Assert::assertNotEmpty($playlists);
    }

    public function testGetPlaylistTracks(): void
    {
        $playlistId = '510gc3bodmwTyBaaKDXuy7';
        $tracks = $this->spotifyAdapter->getPlaylistTracks($playlistId);
        Assert::assertNotEmpty($tracks);
    }
}