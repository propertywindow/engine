<?php
declare(strict_types=1);

namespace Tests\PropertyBundle\Entity;

use PHPUnit\Framework\TestCase;
use PropertyBundle\Entity\SubType;
use PropertyBundle\Entity\Type;

/**
 *  SubType Test
 */
class SubTypeTest extends TestCase
{
    /**
     * @var SubType
     */
    private $subType;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->subType = new SubType();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->subType->getId());

        $type = new Type();

        $this->subType->setType($type);
        $this->assertEquals($type, $this->subType->getType());

        $this->subType->setEn('Detached House');
        $this->assertEquals('Detached House', $this->subType->getEn());

        $this->subType->setNl('Vrijstaand Huis');
        $this->assertEquals('Vrijstaand Huis', $this->subType->getNl());
    }
}
