# Spotify playlists backupper

This tool will backup your playlists as CSV files.

## Setup

1. Register a Spotify Web API client in https://developer.spotify.com/dashboard/application. As callback url
   use http://localhost:8086/symfony/public/index.php/authorize.
2. Configure `.env` (see `.env.sample`)
3. Run the docker container
4. Bash into the docker container, run `cd symfony` & `composer install`
5. Open the authorization url http://localhost:8086/symfony/public/index.php/authorize to cache access token

## Run backup

Bash into the docker container, run `app:backup-playlists`.  
Your backup will be located in `./backups`.