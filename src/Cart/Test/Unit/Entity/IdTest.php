<?php

namespace App\Cart\Test\Unit\Entity;

use App\Cart\Entity\Id;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class IdTest extends TestCase
{
    public function testIdSuccess(): void
    {
        $id = new Id($value = Uuid::uuid4()->toString());

        $this->assertEquals($value, $id->getValue());
    }

    public function testIdInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Id('invalid_id');
    }

    public function testIdEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Id('');
    }

    public function testIdCase(): void
    {
        $value = Uuid::uuid4()->toString();
        $id = new Id(mb_strtoupper($value));

        $this->assertEquals($value, $id->getValue());
    }

    public function testIdGenerate(): void
    {
        $id = Id::generate();

        $this->assertNotEmpty($id->getValue());
    }

}
