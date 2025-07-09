<?php

namespace Test;

use PHPUnit\Framework\TestCase;


class InitTest extends TestCase
{
    public function testSuccess(){
        $var = true;
        self::assertTrue($var);
    }
}
