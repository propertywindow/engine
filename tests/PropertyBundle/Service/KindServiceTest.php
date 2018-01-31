<?php
declare(strict_types=1);

namespace Tests\PropertyBundle\Service;

use PropertyBundle\Entity\Kind;
use PHPUnit\Framework\TestCase;

/**
 *  Kind Service Test
 */
class KindServiceTest extends TestCase
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

    public function testCreateKind()
    {
        $this->kind->setEn('Sale');
        $this->kind->setNl('Koop');

        $this->assertEquals('Sale', $this->kind->getEn());
        $this->assertEquals('Koop', $this->kind->getNl());
    }
}
