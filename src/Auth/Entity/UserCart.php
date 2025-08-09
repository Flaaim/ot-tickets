<?php

declare(strict_types=1);

namespace App\Auth\Entity;

use App\Cart\Entity\Cart;
use App\Product\Entity\Product;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity]
class UserCart
{
    #[ORM\Column(type:"guid")]
    #[ORM\Id]
    private string $id;
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'carts')]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    private User $user;
    #[ORM\ManyToOne(targetEntity: Cart::class)]
    #[ORM\JoinColumn(name: "cart_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    private Cart $cart;

    public function __construct(User $user, Cart $cart)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->user = $user;
        $this->cart = $cart;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }
}
