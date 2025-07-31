<?php

namespace App\Product\Test\UpdateProduct;

use App\Product\Entity\Price;
use App\Product\Test\Builder\ProductBuilder;
use PHPUnit\Framework\TestCase;

class UpdateProductTest extends TestCase
{
    public function testUpdateProduct(): void
    {
        $product = (new ProductBuilder())->build();

        $product->changeName($name = 'New Name');
        $product->changeDescription($description = 'New description');
        $product->changePrice(new Price($price = 10));
        $product->changeCipher($cipher = 'AES-128-CBC');

        $this->assertEquals($name, $product->getName());
        $this->assertEquals($description, $product->getDescription());
        $this->assertEquals($price, $product->getPrice()->getValue());
        $this->assertEquals($cipher, $product->getCipher());
    }
}
