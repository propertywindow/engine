<?php
declare(strict_types=1);

namespace Tests\PropertyBundle\Service;

use PropertyBundle\Entity\Type;
use PHPUnit\Framework\TestCase;

/**
 *  Type Service Test
 */
class TypeServiceTest extends TestCase
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

    public function testCreateType()
    {
        $this->type->setEn('House');
        $this->type->setNl('Huis');

        $this->assertEquals('House', $this->type->getEn());
        $this->assertEquals('Huis', $this->type->getNl());
    }
}
