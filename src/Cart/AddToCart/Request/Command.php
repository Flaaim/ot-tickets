<?php

namespace App\Cart\Add\Request;

class Command
{
    public string $productId = '';
    public ?string $cartId = null;
}
