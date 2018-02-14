<?php
declare(strict_types=1);

namespace Test\PropertyBundle\Entity;

use PHPUnit\Framework\TestCase;
use PropertyBundle\Entity\GeneralNotes;
use PropertyBundle\Entity\Property;

/**
 *  GeneralNotes Test
 */
class GeneralNotesTest extends TestCase
{
    /**
     * @var GeneralNotes
     */
    private $generalNotes;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->generalNotes = new GeneralNotes();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->generalNotes->getId());

        $property = new Property();

        $this->generalNotes->setProperty($property);
        $this->assertEquals($property, $this->generalNotes->getProperty());

        $this->generalNotes->setNote('note');
        $this->assertEquals('note', $this->generalNotes->getNote());

        $created = new \DateTime();

        $this->generalNotes->setCreated($created);
        $this->assertEquals($created, $this->generalNotes->getCreated());

        $this->generalNotes->setUpdated(null);
        $this->assertNull($this->generalNotes->getUpdated());
    }
}
