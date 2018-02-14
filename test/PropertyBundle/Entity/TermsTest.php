<?php
declare(strict_types=1);

namespace Test\PropertyBundle\Entity;

use PHPUnit\Framework\TestCase;
use PropertyBundle\Entity\Terms;

/**
 *  Terms Test
 */
class TermsTest extends TestCase
{
    /**
     * @var Terms
     */
    private $terms;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->terms = new Terms();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->terms->getId());

        $this->terms->setEn('New');
        $this->assertEquals('New', $this->terms->getEn());

        $this->terms->setNl('Nieuw');
        $this->assertEquals('Nieuw', $this->terms->getNl());

        $this->terms->setShowPrice(true);
        $this->assertTrue($this->terms->isShowPrice());
    }
}
