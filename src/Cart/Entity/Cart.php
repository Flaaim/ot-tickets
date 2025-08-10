<?php

namespace App\Cart\Entity;

use App\Product\Entity\Product;
use App\Shared\Domain\ValueObject\Id;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'user_carts')]
class Cart
{
    #[ORM\Id]
    #[ORM\Column(type: 'id', unique: true)]
    private Id $id;
    #[ORM\OneToMany(targetEntity: CartItem::class, mappedBy: 'cart', cascade: ['all'], orphanRemoval: true)]
    private Collection $items;
    public function __construct(Id $id)
    {
        $this->id = $id;
        $this->items = new ArrayCollection();
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function addItem(CartItem $item): void
    {
        foreach ($this->items as $existingItem) {
            if($item->isEqualTo($existingItem)) {
                throw new \DomainException("Item already exists.");
            }
        }
        $item->setCart($this);
        $this->items->add($item);
    }

    public function getItems(): array
    {
        return $this->items->toArray();
    }
}
