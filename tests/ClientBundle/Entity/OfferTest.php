<?php
declare(strict_types=1);

namespace Tests\ClientBundle\Entity;

use ClientBundle\Entity\Buyer;
use ClientBundle\Entity\Offer;
use PHPUnit\Framework\TestCase;
use PropertyBundle\Entity\Property;

/**
 *  Offer Test
 */
class OfferTest extends TestCase
{
    /**
     * @var Offer
     */
    private $offer;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->offer = new Offer();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->offer->getId());

        $buyer = new Buyer();

        $this->offer->setBuyer($buyer);
        $this->assertEquals($buyer, $this->offer->getBuyer());

        $property = new Property();

        $this->offer->setProperty($property);
        $this->assertEquals($property, $this->offer->getProperty());

        $this->offer->setAmount(250000);
        $this->assertEquals(250000, $this->offer->getAmount());

        $entryDate = new \DateTime();

        $this->offer->setEntryDate($entryDate);
        $this->assertEquals($entryDate, $this->offer->getEntryDate());

        $created = new \DateTime();

        $this->offer->setCreated($created);
        $this->assertEquals($created, $this->offer->getCreated());

        $this->offer->setUpdated(null);
        $this->assertNull($this->offer->getUpdated());
    }
}
