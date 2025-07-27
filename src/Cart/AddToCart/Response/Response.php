<?php

namespace App\Cart\Add\Response;

use App\Cart\Entity\Cart;

class Response
{
    private Cart $cart;
    public function __construct(Cart $cart){
        $this->cart = $cart;
    }
}
