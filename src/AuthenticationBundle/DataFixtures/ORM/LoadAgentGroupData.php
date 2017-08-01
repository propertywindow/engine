<?php declare(strict_types=1);

namespace AuthenticationBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AuthenticationBundle\Entity\AgentGroup;

/**
 * Class LoadAgentGroupData
 * @package AuthenticationBundle\DataFixtures\ORM
 */
class LoadAgentGroupData implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $agentGroup = new AgentGroup();
        $agentGroup->setName('The Agent Group');
        $manager->persist($agentGroup);

        $manager->flush();
    }
}
