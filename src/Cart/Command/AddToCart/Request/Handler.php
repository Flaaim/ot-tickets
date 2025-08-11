<?php

namespace App\Cart\Command\AddToCart\Request;

use App\Cart\Command\AddToCart\Response\Response;
use App\Cart\Entity\CartItem;
use App\Cart\Entity\CartRepository;
use App\Product\Entity\ProductRepository;
use App\Shared\Domain\ValueObject\Id;

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

        $item = new CartItem(
            Id::generate(),
            $product,
        );
        $cart->addItem($item);

        $this->carts->save($cart);

        return new Response(
            $cart->getId()->getValue(),
            $cart->getItems()
        );
    }
}
