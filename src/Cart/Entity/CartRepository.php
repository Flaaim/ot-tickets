<?php

namespace App\Cart\Entity;

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
