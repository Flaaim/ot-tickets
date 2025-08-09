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
    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'cart', cascade: ['all'], orphanRemoval: true)]
    private Collection $products;
    public function __construct(Id $id)
    {
        $this->id = $id;
        $this->products = new ArrayCollection();
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function addProduct(Product $product): void
    {
        foreach ($this->products as $existingProduct) {
            if($product->isEqualTo($existingProduct)) {
                throw new \DomainException("Product already exists.");
            }
        }
        $this->products->add($product);
    }

    public function getProducts(): array
    {
        return $this->products->toArray();
    }
}
