<?php

namespace App\Auth\Entity;

use DateTimeImmutable;
use DomainException;
use Webmozart\Assert\Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Token
{
    #[ORM\Column(type: 'string', nullable: true)]
    private string $value;
    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private DateTimeImmutable $expires;

    public function __construct(string $value, DateTimeImmutable $expires)
    {
        Assert::uuid($value);
        $this->value = mb_strtolower($value);
        $this->expires = $expires;
    }
    public function validate(string $value, DateTimeImmutable $expires): void
    {
        if(!$this->isEqualTo($value)){
            throw new DomainException("Token is not valid.");
        }
        if($this->isExpiredTo($expires)){
            throw new DomainException("Token is expired.");
        }
    }
    private function isEqualTo(string $value): bool
    {
        return $this->value === $value;
    }
    public function isExpiredTo(DateTimeImmutable $date): bool
    {
        return $this->expires <= $date;
    }
    public function getExpires(): DateTimeImmutable
    {
        return $this->expires;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
