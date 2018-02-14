<?php
declare(strict_types = 1);

namespace Test\PropertyBundle\Entity;

use PHPUnit\Framework\TestCase;
use PropertyBundle\Entity\Gallery;
use PropertyBundle\Entity\Property;

/**
 *  Gallery Test
 */
class GalleryTest extends TestCase
{
    /**
     * @var Gallery
     */
    private $gallery;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->gallery = new Gallery();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->gallery->getId());

        $property = new Property();

        $this->gallery->setProperty($property);
        $this->assertEquals($property, $this->gallery->getProperty());

        $this->gallery->setMain(false);
        $this->assertFalse($this->gallery->getMain());

        $this->gallery->setPath('path');
        $this->assertEquals('path', $this->gallery->getPath());

        $this->gallery->setOverlay('');
        $this->assertEmpty($this->gallery->getOverlay());

        $this->gallery->setSort(5);
        $this->assertEquals(5, $this->gallery->getSort());

        $created = new \DateTime();

        $this->gallery->setCreated($created);
        $this->assertEquals($created, $this->gallery->getCreated());

        $this->gallery->setUpdated(null);
        $this->assertNull($this->gallery->getUpdated());
    }
}
