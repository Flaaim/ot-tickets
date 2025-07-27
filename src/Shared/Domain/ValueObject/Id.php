<?php

namespace App\Shared\Domain\ValueObject;

use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

final class Id
{
    private string $value;
    public function __construct(string $value)
    {
        Assert::uuid($value, 'Invalid UUID format');
        $this->value = mb_strtolower($value);
    }
    public static function generate(): self
    {
        return new self(Uuid::uuid4()->toString());
    }
    public function getValue(): string
    {
        return $this->value;
    }
    public function equals(self $other): bool
    {
        return $this->getValue() === $other->getValue();
    }
}
