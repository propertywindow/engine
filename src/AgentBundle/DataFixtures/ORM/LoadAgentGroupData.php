<?php declare(strict_types=1);

namespace AgentBundle\DataFixtures\ORM;

use AgentBundle\Entity\AgentGroup;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadAgentGroupData
 * @package AgentBundle\DataFixtures\ORM
 */
class LoadAgentGroupData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $agentGroup = new AgentGroup();
        $agentGroup->setName('The Agent Group');
        $this->addReference('agent_group_1', $agentGroup);
        $manager->persist($agentGroup);

        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 10;
    }
}
