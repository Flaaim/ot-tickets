<?php

namespace App\Auth\Test\Unit\Entity\User;

use App\Auth\Entity\Token;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class TokenTest extends TestCase
{
    public function testTokenSuccess(): void
    {
        $token = new Token($value = Uuid::uuid4()->toString(), $date = new DateTimeImmutable());
        $this->assertEquals($token->getValue(), $value);
        $this->assertEquals($token->getExpires(), $date);
    }
    public function testTokenEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Token('', $date = new DateTimeImmutable());
    }
    public function testTokenInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Token('invalid', new DateTimeImmutable());
    }

    public function testTokenCase(): void
    {
        $value = Uuid::uuid4()->toString();
        $token = new Token(mb_strtoupper($value), new DateTimeImmutable());
        $this->assertEquals($value, $token->getValue());
    }
}
