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
        $agentGroup->setName('Property Window');
        $this->addReference('agent_group_propertywindow', $agentGroup);
        $manager->persist($agentGroup);

        $agentGroup = new AgentGroup();
        $agentGroup->setName('Annan Solicitors & Estate Agents');
        $this->addReference('agent_group_annan', $agentGroup);
        $manager->persist($agentGroup);

        $agentGroup = new AgentGroup();
        $agentGroup->setName('Geo. & Jas. Oliver W.S.');
        $this->addReference('agent_group_oliver', $agentGroup);
        $manager->persist($agentGroup);

        $agentGroup = new AgentGroup();
        $agentGroup->setName('Deans Solicitors & Estate Agents LLP');
        $this->addReference('agent_group_deans', $agentGroup);
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
