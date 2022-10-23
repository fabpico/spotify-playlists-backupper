<?php declare(strict_types=1);

namespace App\Commands;

use App\Adapters\SpotifyAdapter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class BackupPlaylistsCommand extends Command
{
    private const BACKUP_PATH = '/var/www/html/backups';
    private SpotifyAdapter $spotifyAdapter;

    public function __construct(SpotifyAdapter $spotifyAdapter)
    {
        parent::__construct('app:backup-playlists');
        $this->spotifyAdapter = $spotifyAdapter;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $momentBackupPath = $this->createMomentBackupPath();
        if (!is_dir($momentBackupPath)) {
            mkdir($momentBackupPath, 0777, true);
        }
        $playlists = $this->spotifyAdapter->getPlaylists();
        foreach ($playlists as $playlist) {
            $playlistName = $this->sanitizePlaylistName($playlist['name']);
            $playlistFile = fopen("$momentBackupPath/{$playlistName}.csv", 'w');
            $trackRows = $this->createTrackRows($playlist['id']);
            $firstRow = ['Name', 'Artists'];
            $allRows = array_merge([$firstRow], $trackRows);
            foreach ($allRows as $row) {
                fputcsv($playlistFile, $row);
            }
            fclose($playlistFile);
        }
        return Command::SUCCESS;
    }

    private function createTrackRows(string $playlistId): array
    {
        $tracks = $this->spotifyAdapter->getPlaylistTracks($playlistId);
        return array_map(function (array $track): array {
            $artistNames = array_map(fn(array $artist): string => $artist['name'], $track['track']['artists']);
            return [
                'name' => $track['track']['name'],
                'artists' => implode(', ', $artistNames),
            ];
        }, $tracks);
    }

    private function sanitizePlaylistName(string $name): string
    {
        return str_replace('/', '-', $name);
    }

    private function createMomentBackupPath(): string
    {
        $now = new \DateTimeImmutable();
        return self::BACKUP_PATH . '/' . $now->format('Y-m-d H-i-s');
    }
}