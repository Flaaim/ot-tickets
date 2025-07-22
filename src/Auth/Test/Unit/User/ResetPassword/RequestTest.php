<?php

namespace App\Auth\Test\Unit\User\ResetPassword;

use App\Auth\Entity\Token;
use App\Auth\Test\Builder\UserBuilder;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use function PHPUnit\Framework\assertNotNull;

class RequestTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = (new UserBuilder())
            ->active()
            ->build();

        $now = new DateTimeImmutable();
        $token = $this->createToken($now->modify('+1 hour'));

        $user->requestPasswordReset($token, $now);

        self::assertNotNull($user->getResetPasswordToken());
        self::assertEquals($token, $user->getResetPasswordToken());
    }
    public function testNotActive(): void
    {
        $user = (new UserBuilder())
            ->build();

        $now = new DateTimeImmutable();
        $token = $this->createToken($now->modify('+1 hour'));
        $this->expectExceptionMessage('User is not active.');
        $user->requestPasswordReset($token, $now);
    }

    public function testAlready(): void
    {
        $user = (new UserBuilder())
            ->active()
            ->build();
        $now = new DateTimeImmutable();
        $token = $this->createToken($now->modify('+1 hour'));
        $user->requestPasswordReset($token, $now);
        $this->expectExceptionMessage('Resetting is already requested.');
        $user->requestPasswordReset($token, $now);
    }

    public function testExpired(): void
    {
        $user = (new UserBuilder())
            ->active()
            ->build();

        $now = new DateTimeImmutable();
        $token = $this->createToken($now->modify('+1 hour'));
        $user->requestPasswordReset($token, $now);

        $newDate = $now->modify('+2 hours');

        $newToken = $this->createToken($newDate->modify('+2 hour'));

        $user->requestPasswordReset($newToken, $newDate);
        self::assertEquals($newToken, $user->getResetPasswordToken());
    }
    private function createToken(DateTimeImmutable $date): Token
    {
        return new Token(
            Uuid::uuid4()->toString(),
           $date
        );
    }
}
