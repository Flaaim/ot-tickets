<?php

namespace App\Cart\GetCart\Request;

use App\Cart\Entity\CartRepository;
use App\Cart\GetCart\Response\Response;
use App\Shared\Domain\ValueObject\Id;


class Handler
{
    private CartRepository $carts;
    public function __construct(CartRepository $carts)
    {
        $this->carts = $carts;
    }
    public function handle(Command $command): Response
    {
        $cart = $this->carts->get(new Id($command->id));

        return new Response(
            $cart->getId()->getValue(),
            $cart->getProducts()
        );
    }
}
