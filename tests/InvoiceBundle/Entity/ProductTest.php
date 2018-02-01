<?php
declare(strict_types=1);

namespace Tests\InvoiceBundle\Entity;

use InvoiceBundle\Entity\Product;
use PHPUnit\Framework\TestCase;

/**
 *  Product Test
 */
class ProductTest extends TestCase
{
    /**
     * @var Product
     */
    private $product;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->product = new Product();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->product->getId());

        $this->product->setName('product');
        $this->assertEquals('product', $this->product->getName());

        $this->product->setDescription('description');
        $this->assertEquals('description', $this->product->getDescription());

        $this->product->setPrice(50);
        $this->assertEquals(50, $this->product->getPrice());
    }
}
