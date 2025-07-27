<?php

namespace App\Product\Entity;


use Webmozart\Assert\Assert;

final class Price
{
    private float $value;
    public function __construct(float $value)
    {
        Assert::greaterThan($value, 0, 'Price must be positive');
        $this->value = round($value, 2); // Округляем до копеек/центов
    }

    public function getValue(): float
    {
        return $this->value;
    }
    public function add(self $other): self
    {
        return new self($this->value + $other->value);
    }
    public function subtract(self $other): self
    {
        return new self($this->value - $other->value);
    }
    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }
}
