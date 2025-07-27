<?php

namespace App\Cart\Entity;

use App\Shared\Domain\ValueObject\Id;

interface CartRepository
{
    /**
     * @param Id $id
     * @return Cart
     * @throws \DomainException
     */
    public function get(Id $id): Cart;

    public function getCurrentCart(): Cart; //Для сессий.

    public function save(Cart $cart): void;
}
