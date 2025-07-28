<?php

namespace App\Cart\AddToCart\Request;

class Command
{
    public string $productId = '';
    public ?string $cartId = null;
}
