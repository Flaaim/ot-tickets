<?php

namespace App\Auth\Test\Unit\User\Entity\User;

use App\Auth\Entity\Id;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class IdTest extends TestCase
{
    public function testIdSuccess(): void
    {
        $id = new Id($value = Uuid::uuid4()->toString());
        $this->assertEquals($id->getValue(), $value);
    }
    public function testIdInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Id('invalid');
    }

    public function testIdEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Id('');
    }
    public function testIdCase(): void
    {
        $value = Uuid::uuid4()->toString();
        $id = new Id(mb_strtoupper($value));
        $this->assertEquals($id->getValue(), $value);

    }
    public function testGenerate(): void
    {
        $id = Id::generate();
        $this->assertNotEmpty($id->getValue());

    }
}
