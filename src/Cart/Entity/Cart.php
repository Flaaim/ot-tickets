<?php

namespace App\Cart\Entity;

class Cart
{
    private Id $id;
    public function __construct(Id $id)
    {
        $this->id = $id;
    }

    public function getId(): Id
    {
        return $this->id;
    }

}
