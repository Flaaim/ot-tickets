<?php

namespace App\Cart\Command\AddToCart\Request;

class Command
{
    public string $productId = '';
    public ?string $cartId = null;
}
