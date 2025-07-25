<?php

namespace App\Cart\Entity;

Interface CartRepository
{
    /**
     * @param Id $id
     * @return Cart
     * @throws \DomainException
     */
    public function get(Id $id): Cart;
}
