<?php
declare(strict_types = 1);

namespace Tests\InvoiceBundle\Entity;

use InvoiceBundle\Entity\Invoice;
use InvoiceBundle\Entity\Payment;
use PHPUnit\Framework\TestCase;

/**
 *  Payment Test
 */
class PaymentTest extends TestCase
{
    /**
     * @var Payment
     */
    private $payment;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->payment = new Payment();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->payment->getId());

        $invoice = new Invoice();

        $this->payment->setInvoice($invoice);
        $this->assertEquals($invoice, $this->payment->getInvoice());

        $this->payment->setAmount(2);
        $this->assertEquals(2, $this->payment->getAmount());

        $datetime = new \DateTime();

        $this->payment->setDatetime($datetime);
        $this->assertEquals($datetime, $this->payment->getDatetime());
    }
}
