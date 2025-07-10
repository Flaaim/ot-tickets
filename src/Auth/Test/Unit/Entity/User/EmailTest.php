<?php

namespace App\Auth\Test\Unit\Entity\User;

use App\Auth\Entity\Email;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class EmailTest extends TestCase
{
    public function testEmailSuccess(): void
    {
        $email = new Email($value = 'email@app.ru');
        assertEquals($email->getValue(), $value);
    }

    public function testEmailEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Email('');
    }
    public function testEmailInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Email('invalid');
    }

    public function testEmailCase(): void
    {
        $email = new Email($value = 'EMAIL@APP.ru');
        assertEquals($email->getValue(), mb_strtolower($value));
    }
}
