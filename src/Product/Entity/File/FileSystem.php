<?php

namespace App\Product\Entity\File;

class FileSystem
{
    public function isDirectory(string $path): bool
    {
        return is_dir($path);
    }
    public function makeDirectory(string $path): bool
    {
        return mkdir($path, 0755, true);
    }
}
