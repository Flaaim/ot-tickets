<?php

namespace App\Product\Entity;


use Webmozart\Assert\Assert;

final class Price
{
    private float $value;
    private string $currency;
    public function __construct(float $value, string $currency = 'RUB')
    {
        Assert::greaterThan($value, 0, 'Price must be positive');
        Assert::length($currency, 3, 'Currency must be 3-letter code (e.g. RUB)');
        $this->value = round($value, 2); // Округляем до копеек/центов
        $this->currency = mb_strtoupper($currency);
    }

    public function getValue(): float
    {
        return $this->value;
    }
    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function add(self $other): self
    {
        return new self($this->value + $other->value, $this->currency);
    }
}
