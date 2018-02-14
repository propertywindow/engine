<?php
declare(strict_types=1);

namespace Test\AppBundle\Entity;

use PHPUnit\Framework\TestCase;
use AppBundle\Entity\Acceptance;

/**
 *  Acceptance Test
 */
class AcceptanceTest extends TestCase
{
    /**
     * @var Acceptance
     */
    private $acceptance;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->acceptance = new Acceptance();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->acceptance->getId());

        $this->acceptance->setEn('Accepted');
        $this->assertEquals('Accepted', $this->acceptance->getEn());

        $this->acceptance->setNl('Geaccepteerd');
        $this->assertEquals('Geaccepteerd', $this->acceptance->getNl());
    }
}
