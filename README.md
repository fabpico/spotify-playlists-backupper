# Spotify playlists backupper

Backup your Spotify playlists as CSV files.

## Requirements

- Docker
- Registration of a [Spotify Web API client](https://developer.spotify.com/dashboard).
    - As callback url, use `http://localhost:8086/public/index.php/authorize`.

## Install

1. Add `./app/.env` (see `./app/.env.sample`)
2. Bash into the container: `cd .docker`, `docker compose up -d`, `docker compose exec php-apache bash`
3. Install packages: `composer install`
4. Warmup cache: `php bin/console cache:warmup`

## Use

1. Cache the access token: Go to http://localhost:8086/public/index.php/authorize (you may have to log in to Spotify)
2. Bash into the container
3. Run `php bin/console app:backup-playlists`

Your backup will be located in `./app/backups`.