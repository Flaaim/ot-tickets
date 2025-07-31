<?php

namespace App\Product\Entity;

class Status
{
    private const ACTIVE = 'active';
    private const ARCHIVED = 'archived';
    private string $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }
    public function isActive(): bool
    {
        return $this->name === self::ACTIVE;
    }
    public function isArchived(): bool
    {
        return $this->name === self::ARCHIVED;
    }
    public static function active(): self
    {
        return new self(self::ACTIVE);
    }
    public static function archive(): self
    {
        return new self(self::ARCHIVED);
    }
}
