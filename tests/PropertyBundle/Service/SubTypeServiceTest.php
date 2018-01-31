<?php
declare(strict_types=1);

namespace Tests\PropertyBundle\Service;

use PropertyBundle\Entity\SubType;
use PHPUnit\Framework\TestCase;
use PropertyBundle\Entity\Type;

/**
 *  SubType Service Test
 */
class SubTypeServiceTest extends TestCase
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

    public function testCreateTerm()
    {
        $type = new Type();

        $this->subType->setType($type);
        $this->subType->setEn('Detached House');
        $this->subType->setNl('Vrijstaand Huis');

        $this->assertEquals($type, $this->subType->getType());
        $this->assertEquals('Detached House', $this->subType->getEn());
        $this->assertEquals('Vrijstaand Huis', $this->subType->getNl());
    }
}
