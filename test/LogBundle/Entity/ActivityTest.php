<?php
declare(strict_types = 1);

namespace Tests\LogBundle\Entity;

use AgentBundle\Entity\Agent;
use AuthenticationBundle\Entity\User;
use LogBundle\Entity\Activity;
use PHPUnit\Framework\TestCase;

/**
 *  Activity Test
 */
class ActivityTest extends TestCase
{
    /**
     * @var Activity
     */
    private $activity;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->activity = new Activity();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->activity->getId());

        $user = new User();

        $this->activity->setUser($user);
        $this->assertEquals($user, $this->activity->getUser());

        $agent = new Agent();

        $this->activity->setAgent($agent);
        $this->assertEquals($agent, $this->activity->getAgent());

        $this->activity->setActionId(2);
        $this->assertEquals(2, $this->activity->getActionId());

        $this->activity->setActionName('action');
        $this->assertEquals('action', $this->activity->getActionName());

        $this->activity->setActionCategory('category');
        $this->assertEquals('category', $this->activity->getActionCategory());

        $this->activity->setOldValue('');
        $this->assertEmpty($this->activity->getOldValue());

        $this->activity->setNewValue('value');
        $this->assertEquals('value', $this->activity->getNewValue());

        $created = new \DateTime();

        $this->activity->setCreated($created);
        $this->assertEquals($created, $this->activity->getCreated());
    }
}
