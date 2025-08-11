<?php

namespace App\Product\Entity;

use Webmozart\Assert\Assert;

class Status
{
    public const ACTIVE = 'active';
    public const ARCHIVED = 'archived';
    private string $name;

    public function __construct(string $name)
    {
        Assert::oneOf($name, [
            self::ACTIVE,
            self::ARCHIVED,
        ]);
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
    public function getName(): string
    {
        return $this->name;
    }
}
