<?php
declare(strict_types = 1);

namespace AlertBundle\DataFixtures\ORM;

use AgentBundle\Entity\AgentGroup;
use AlertBundle\Entity\Applicant;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Load Applicant Data
 */
class LoadApplicantData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $applicant = new Applicant();
        /** @var AgentGroup $agentGroup */
        $agentGroup = $this->getReference('agent_group_annan');
        $applicant->setAgentGroup($agentGroup);
        $applicant->setName('Marc Geurts');
        $applicant->setEmail('geurtsmarc@hotmail.com');
        $applicant->setPhone('0611389156');
        $applicant->setProtection(false);
        $applicant->setCountry('NL');
        $this->setReference('applicant_1', $applicant);
        $manager->persist($applicant);

        $applicant = new Applicant();
        /** @var AgentGroup $agentGroup */
        $agentGroup = $this->getReference('agent_group_annan');
        $applicant->setAgentGroup($agentGroup);
        $applicant->setName('Antica Culina');
        $applicant->setEmail('a.culina@yahoo.com');
        $applicant->setPhone('');
        $applicant->setProtection(true);
        $applicant->setCountry('NL');
        $this->setReference('applicant_2', $applicant);
        $manager->persist($applicant);

        $applicant = new Applicant();
        /** @var AgentGroup $agentGroup */
        $agentGroup = $this->getReference('agent_group_annan');
        $applicant->setAgentGroup($agentGroup);
        $applicant->setName('Iain Anderson');
        $applicant->setEmail('iain@anderson.co.uk');
        $applicant->setPhone('');
        $applicant->setProtection(true);
        $applicant->setCountry('GB');
        $this->setReference('applicant_3', $applicant);
        $manager->persist($applicant);

        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 60;
    }
}
