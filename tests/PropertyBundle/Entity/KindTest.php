<?php
declare(strict_types=1);

namespace Tests\PropertyBundle\Entity;

use PHPUnit\Framework\TestCase;
use PropertyBundle\Entity\Kind;

/**
 *  Kind Test
 */
class KindTest extends TestCase
{
    /**
     * @var Kind
     */
    private $kind;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->kind = new Kind();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->kind->getId());

        $this->kind->setEn('Sale');
        $this->assertEquals('Sale', $this->kind->getEn());

        $this->kind->setNl('Koop');
        $this->assertEquals('Koop', $this->kind->getNl());
    }
}
