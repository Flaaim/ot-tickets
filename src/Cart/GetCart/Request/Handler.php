<?php

namespace App\Cart\Get\Request;

use App\Cart\Entity\CartRepository;
use App\Cart\Get\Response\Response;
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

        return new Response($cart);
    }
}
