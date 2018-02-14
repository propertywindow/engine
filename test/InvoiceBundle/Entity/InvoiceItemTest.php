<?php
declare(strict_types = 1);

namespace Test\InvoiceBundle\Entity;

use InvoiceBundle\Entity\Invoice;
use InvoiceBundle\Entity\InvoiceItem;
use InvoiceBundle\Entity\Product;
use PHPUnit\Framework\TestCase;

/**
 *  InvoiceItem Test
 */
class InvoiceItemTest extends TestCase
{
    /**
     * @var InvoiceItem
     */
    private $invoiceItem;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->invoiceItem = new InvoiceItem();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->invoiceItem->getId());

        $invoice = new Invoice();

        $this->invoiceItem->setInvoice($invoice);
        $this->assertEquals($invoice, $this->invoiceItem->getInvoice());

        $product = new Product();

        $this->invoiceItem->setProduct($product);
        $this->assertEquals($product, $this->invoiceItem->getProduct());

        $datetime = new \DateTime();

        $this->invoiceItem->setDatetime($datetime);
        $this->assertEquals($datetime, $this->invoiceItem->getDatetime());

        $this->invoiceItem->setAmount(1);
        $this->assertEquals(1, $this->invoiceItem->getAmount());

        $this->invoiceItem->setPrice(1000);
        $this->assertEquals(1000, $this->invoiceItem->getPrice());

        $this->invoiceItem->setDiscount(2);
        $this->assertEquals(2, $this->invoiceItem->getDiscount());
    }
}
