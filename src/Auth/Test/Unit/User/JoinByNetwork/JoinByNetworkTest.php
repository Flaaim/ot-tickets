<?php

namespace App\Auth\Test\Unit\User\JoinByNetwork;

use App\Auth\Entity\Email;
use App\Auth\Entity\Id;
use App\Auth\Entity\Network;
use App\Auth\Entity\Role;
use App\Auth\Entity\User;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class JoinByNetworkTest extends TestCase
{
    public function testSuccess()
    {
        $user = User::requestJoinByNetwork(
            $id = Id::generate(),
            $date = new DateTimeImmutable(),
            $email = new Email('test@email.ru'),
            $network = new Network('vk', '0001')
        );

        self::assertEquals($id, $user->getId());
        self::assertEquals($date, $user->getDate());
        self::assertEquals($email, $user->getEmail());

        self::assertTrue($user->isActive());
        self::assertFalse($user->isWait());

        self::assertEquals(Role::USER, $user->getRole()->getName());

        self::assertCount(1, $networks = $user->getNetworks());
        self::assertEquals($network, $networks[0] ?? null);
    }
}
