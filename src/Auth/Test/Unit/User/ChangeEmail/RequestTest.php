<?php

namespace App\Auth\Test\Unit\User\ChangeEmail;

use App\Auth\Entity\Email;
use App\Auth\Entity\Token;
use App\Auth\Test\Builder\UserBuilder;
use Couchbase\User;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class RequestTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = (new UserBuilder())->active()
            ->withEmail($old = new Email('old-email@app.test'))
            ->build();

        $now = new DateTimeImmutable();
        $token = $this->createToken($now->modify('+1 hour'));

        $user->requestEmailChanging($token, $now, $new = new Email('new-email@app.test'));

        $this->assertEquals($old, $user->getEmail());
        $this->assertEquals($new, $user->getNewEmail());
        $this->assertEquals($token, $user->getNewEmailToken());
    }

    public function testSame(): void
    {
        $user = (new UserBuilder())->active()
            ->withEmail($old = new Email('old-email@app.test'))
            ->build();

        $now = new DateTimeImmutable();
        $token = $this->createToken($now->modify('+1 hour'));

        $this->expectExceptionMessage('Email is already same.');
        $user->requestEmailChanging($token, $now, $old);
    }
    public function testExpired(): void
    {
        $user = (new UserBuilder())->active()->build();

        $now = new DateTimeImmutable();
        $token = $this->createToken($now->modify('+1 hour'));
        $user->requestEmailChanging($token, $now, new Email('temp-email@app.test'));

        $newDate = $now->modify('+2 hours');
        $newToken = $this->createToken($newDate->modify('+1 hour'));
        $user->requestEmailChanging($newToken, $newDate, $newEmail = new Email('new-email@app.test'));

        self::assertEquals($newToken, $user->getNewEmailToken());
        self::assertEquals($newEmail, $user->getNewEmail());
    }
    public function testAlready(): void
    {
        $user = (new UserBuilder())->active()
            ->build();

        $now = new DateTimeImmutable();
        $token = $this->createToken($now->modify('+1 hour'));

        $user->requestEmailChanging($token, $now, $new = new Email('new-email@app.test'));
        $this->expectExceptionMessage('Changing is already requested.');
        $user->requestEmailChanging($token, $now, $new);

    }
    private function createToken(DateTimeImmutable $date): Token
    {
        return new Token(
            Uuid::uuid4()->toString(),
            $date
        );
    }
}
