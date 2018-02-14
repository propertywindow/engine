<?php
declare(strict_types = 1);

namespace Tests\AuthenticationBundle\Entity;

use AuthenticationBundle\Entity\ServiceGroup;
use PHPUnit\Framework\TestCase;

/**
 *  ServiceGroup Test
 */
class ServiceGroupTest extends TestCase
{
    /**
     * @var ServiceGroup
     */
    private $serviceGroup;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->serviceGroup = new ServiceGroup();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->serviceGroup->getId());

        $this->serviceGroup->setEn('service');
        $this->assertEquals('service', $this->serviceGroup->getEn());

        $this->serviceGroup->setNl('dienst');
        $this->assertEquals('dienst', $this->serviceGroup->getNl());

        $this->serviceGroup->setIcon('icon.png');
        $this->assertEquals('icon.png', $this->serviceGroup->getIcon());

        $this->serviceGroup->setUrl('');
        $this->assertEmpty($this->serviceGroup->getUrl());
    }
}
