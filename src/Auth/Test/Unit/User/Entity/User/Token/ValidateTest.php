<?php

namespace App\Auth\Test\Unit\User\Entity\User\Token;

use App\Auth\Entity\Token;
use DateTimeImmutable;
use DomainException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * @covers Token::validate
 */
class ValidateTest extends TestCase
{
    /**
     * @doesNotPerformAssertions
     */
    public function testSuccess(): void
    {
        $token = new Token(
            $value = Uuid::uuid4()->toString(),
            $expires = new DateTimeImmutable()
        );

        $token->validate($value, $expires->modify('-1 secs'));
    }

    public function testWrong(): void
    {
        $token = new Token(
          $value = Uuid::uuid4()->toString(),
          $expires = new DateTimeImmutable()
        );

        $this->expectException(DomainException::class);
        $token->validate(Uuid::uuid4()->toString(), $expires);
    }

    public function testExpired(): void
    {
        $token = new Token(
            $value = Uuid::uuid4()->toString(),
            $expires = new DateTimeImmutable()
        );

        $this->expectException(DomainException::class);
        $token->validate($value, $expires->modify('+1 secs'));
    }
}
