<?php

namespace App\Auth\Test\Unit\JoinByEmail;

use App\Auth\Entity\Email;
use App\Auth\Entity\Id;
use App\Auth\Entity\Token;
use App\Auth\Entity\User;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class RequestTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = new User(
            $id = Id::generate(),
            $date = new DateTimeImmutable(),
            $email = new Email('some@email.ru'),
            $hash = 'hash',
            $token = new Token(Uuid::uuid4()->toString(), new DateTimeImmutable())
        );

        self::assertEquals($id, $user->getId());
        self::assertEquals($date, $user->getDate());
        self::assertEquals($email, $user->getEmail());
        self::assertEquals($hash, $user->getPasswordHash());
        self::assertEquals($token, $user->getJoinConfirmToken());
    }


}
