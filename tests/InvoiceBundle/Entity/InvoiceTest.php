<?php
declare(strict_types=1);

namespace Tests\InvoiceBundle\Entity;

use AgentBundle\Entity\Agent;
use InvoiceBundle\Entity\Invoice;
use PHPUnit\Framework\TestCase;

/**
 *  Invoice Test
 */
class InvoiceTest extends TestCase
{
    /**
     * @var Invoice
     */
    private $invoice;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->invoice = new Invoice();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->invoice->getId());

        $agent = new Agent();

        $this->invoice->setAgent($agent);
        $this->assertEquals($agent, $this->invoice->getAgent());

        $datetime = new \DateTime();

        $this->invoice->setDatetime($datetime);
        $this->assertEquals($datetime, $this->invoice->getDatetime());

        $this->invoice->setAmount(2);
        $this->assertEquals(2, $this->invoice->getAmount());

        $this->invoice->setPrice(1000);
        $this->assertEquals(1000, $this->invoice->getPrice());

        $this->invoice->setDescription('Description');
        $this->assertEquals('Description', $this->invoice->getDescription());
    }
}
