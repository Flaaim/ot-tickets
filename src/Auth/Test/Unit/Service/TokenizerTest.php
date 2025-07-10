<?php

namespace App\Auth\Test\Unit\Service;

use App\Auth\Service\Tokenizer;
use DateInterval;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class TokenizerTest extends TestCase
{
    public function testSuccess(): void
    {
        $interval = new DateInterval('PT1H');

        $date = new DateTimeImmutable('+1 day');

        $tokenizer = new Tokenizer($interval);

        $token = $tokenizer->generate($date);

        assertEquals($date->add($interval), $token->getExpires());
    }
}
