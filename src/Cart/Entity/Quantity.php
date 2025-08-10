<?php

namespace App\Cart\Entity;

use Webmozart\Assert\Assert;

class Quantity
{
    public const DEFAULT = 1;

    private int $quantity;
    public function __construct(int $quantity)
    {
        Assert::oneOf($quantity, [
            self::DEFAULT,
        ]);
        $this->quantity = $quantity;
    }
    public function getValue(): int
    {
        return $this->quantity;
    }
    public static function default(): self
    {
        return new self(self::DEFAULT);
    }
}
