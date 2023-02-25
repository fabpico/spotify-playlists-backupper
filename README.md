# Spotify playlists backupper

Backup your Spotify playlists as CSV files.

## Requirements

- Docker
- Registration of a [Spotify Web API client](https://developer.spotify.com/dashboard/application). As callback url,
  use `http://localhost:8086/symfony/public/index.php/authorize`.

## Install

1. Configure `./symfony/.env` (see `./symfony/.env.sample`)
2. Open PHP terminal: `docker compose up -d`, `docker compose exec php bash`
3. Install PHP packages: `cd symfony` & `composer install`
4. Open the authorization url http://localhost:8086/symfony/public/index.php/authorize to cache the access token

## Use

1. Open PHP terminal: `docker compose up -d`, `docker compose exec php bash`
2. In `./symfony`, execute: `php bin/console app:backup-playlists`

Your backup will be located in `./backups`.