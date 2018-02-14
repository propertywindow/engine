<?php
declare(strict_types = 1);

namespace Test\PropertyBundle\Entity;

use PHPUnit\Framework\TestCase;
use PropertyBundle\Entity\Type;

/**
 *  Type Test
 */
class TypeTest extends TestCase
{
    /**
     * @var Type
     */
    private $type;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->type = new Type();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->type->getId());

        $this->type->setEn('House');
        $this->assertEquals('House', $this->type->getEn());

        $this->type->setNl('Huis');
        $this->assertEquals('Huis', $this->type->getNl());
    }
}
