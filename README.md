# Spotify playlists backupper

Backup your Spotify playlists as CSV files.

## Requirements

- Docker
- Registration of a [Spotify Web API client](https://developer.spotify.com/dashboard).
    - As callback url, use `http://localhost:8086/public/index.php/authorize`.

## Install

1. Add `./app/.env` (see `./app/.env.sample`)
2. Start container: `docker compose up -d`
3. In the php container: `composer install && php bin/console cache:warmup`

## Use

1. Cache the access token: Go to http://localhost:8086/public/index.php/authorize (you may have to log in to Spotify)
2. In the php container: `php bin/console app:backup-playlists`

Your backup will be located in `./app/backups`.