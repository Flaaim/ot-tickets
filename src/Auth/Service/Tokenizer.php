<?php

namespace App\Auth\Service;

use App\Auth\Entity\Token;
use DateInterval;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

class Tokenizer
{
    private DateInterval $interval;
    public function __construct(DateInterval $interval)
    {
        $this->interval = $interval;
    }
    public function generate(DateTimeImmutable $date): Token
    {
        return new Token(
            Uuid::uuid4()->toString(),
            $date->add($this->interval),
        );
    }
}
