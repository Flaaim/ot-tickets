<?php

namespace App\Cart\Entity;

use App\Auth\Entity\User;
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
    #[ORM\OneToOne(targetEntity: User::class, inversedBy: 'cart')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private User $user;
    public function __construct(Id $id, User $user)
    {
        $this->id = $id;
        $this->user = $user;
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
    public function clear(): void
    {
        $this->items->clear();
    }

    public function removeItem(CartItem $item): void
    {
        $this->items->removeElement($item);
    }
}
