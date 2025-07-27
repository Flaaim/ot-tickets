<?php

namespace App\Cart\Add\Request;

use App\Cart\Add\Response\Response;
use App\Cart\Entity\CartRepository;
use App\Cart\Entity\Id;
use App\Cart\Entity\ProductRepository;

class Handler
{
    private CartRepository $carts;
    private ProductRepository $products;
    public function __construct(CartRepository $carts, ProductRepository $products)
    {
        $this->carts = $carts;
        $this->products = $products;
    }

    public function handle(Command $command): Response
    {
        if($command->cartId !== null) {
            $cart = $this->carts->get(new Id($command->cartId));
        }else{
            $cart = $this->carts->getCurrentCart();
        }
        $product = $this->products->get(new Id($command->productId));

        $cart->addProduct($product);

        $this->carts->save($cart);

        return new Response($cart);
    }
}
