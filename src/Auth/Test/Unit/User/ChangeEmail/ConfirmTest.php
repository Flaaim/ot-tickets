<?php

namespace App\Auth\Test\Unit\User\ChangeEmail;

use App\Auth\Entity\Email;
use App\Auth\Entity\Token;
use App\Auth\Test\Builder\UserBuilder;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ConfirmTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = (new UserBuilder())
            ->active()->build();
        $now = new DateTimeImmutable();
        $token = $this->createToken($now->modify('+1 hour'));

        $user->requestEmailChanging($token, $now, $newEmail = new Email('new@email.com'));

        $user->changeEmail($token->getValue(), $now);

        $this->assertEquals($user->getEmail(), $newEmail);
        $this->assertNull($user->getNewEmail());
        $this->assertNull($user->getNewEmailToken());
    }

    public function testInvalidToken(): void
    {
        $user = (new UserBuilder())
            ->active()->build();

        $now = new DateTimeImmutable();
        $token = $this->createToken($now->modify('+1 hour'));

        $user->requestEmailChanging($token, $now, new Email('new@email.com'));

        $this->expectExceptionMessage('Token is not valid.');

        $user->changeEmail('invalid_token', $now);
    }

    public function testExpiredToken(): void
    {
        $user = (new UserBuilder())->active()->build();
        $now = new DateTimeImmutable();

        $token = $this->createToken($now->modify('+1 hour'));
        $user->requestEmailChanging($token, $now, new Email('new@email.com'));

        $this->expectExceptionMessage('Token is expired.');
        $user->changeEmail($token->getValue(), $now->modify('+2 hour'));

    }

    public function testNotRequested(): void
    {
        $user = (new UserBuilder())->active()->build();

        $now = new DateTimeImmutable();

        $token = $this->createToken($now->modify('+1 hour'));
        $this->expectExceptionMessage('Changing is not requested.');
        $user->changeEmail($token->getValue(), $now);
    }
    private function createToken(DateTimeImmutable $date): Token
    {
        return new Token(
            Uuid::uuid4()->toString(),
            $date
        );
    }
}
