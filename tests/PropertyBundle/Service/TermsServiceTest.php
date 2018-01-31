<?php
declare(strict_types=1);

namespace Tests\PropertyBundle\Service;

use PropertyBundle\Entity\Terms;
use PHPUnit\Framework\TestCase;

/**
 *  Terms Service Test
 */
class TermsServiceTest extends TestCase
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

    public function testCreateTerm()
    {
        $this->terms->setEn('New');
        $this->terms->setNl('Nieuw');
        $this->terms->setShowPrice(false);

        $this->assertEquals('New', $this->terms->getEn());
        $this->assertEquals('Nieuw', $this->terms->getNl());
        $this->assertInternalType('bool', $this->terms->getShowPrice());
        $this->assertEquals(false, $this->terms->getShowPrice());
    }
}
