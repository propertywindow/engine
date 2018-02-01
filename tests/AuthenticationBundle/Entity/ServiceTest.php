<?php
declare(strict_types=1);

namespace Tests\AuthenticationBundle\Entity;

use AuthenticationBundle\Entity\Service;
use AuthenticationBundle\Entity\ServiceGroup;
use PHPUnit\Framework\TestCase;

/**
 *  Service Test
 */
class ServiceTest extends TestCase
{
    /**
     * @var Service
     */
    private $service;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->service = new Service();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->service->getId());

        $serviceGroup = new ServiceGroup();

        $this->service->setServiceGroup($serviceGroup);
        $this->assertEquals($serviceGroup, $this->service->getServiceGroup());

        $this->service->setFunctionName('function');
        $this->assertEquals('function', $this->service->getFunctionName());

        $this->service->setEn('service');
        $this->assertEquals('service', $this->service->getEn());

        $this->service->setNl('dienst');
        $this->assertEquals('dienst', $this->service->getNl());

        $this->service->setIcon('icon.png');
        $this->assertEquals('icon.png', $this->service->getIcon());

        $this->service->setUrl('');
        $this->assertEmpty($this->service->getUrl());

        $this->service->setVisible(true);
        $this->assertTrue($this->service->getVisible());
    }
}
