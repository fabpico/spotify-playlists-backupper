<?php declare(strict_types=1);

namespace App\Common;

final class Cache
{
    private const FOLDER = __DIR__ . '/../../var/cache';

    public function save(string $name, string $value): void
    {
        file_put_contents(self::FOLDER . "/$name.txt", $value);
    }

    public function get(string $name): string
    {
        return file_get_contents(self::FOLDER . "/$name.txt");
    }
}