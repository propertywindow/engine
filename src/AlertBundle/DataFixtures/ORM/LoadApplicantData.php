<?php declare(strict_types=1);

namespace AlertBundle\DataFixtures\ORM;

use AlertBundle\Entity\Applicant;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadApplicantData
 * @package AlertBundle\DataFixtures\ORM
 */
class LoadApplicantData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $applicant = new Applicant();
        $applicant->setAgentGroup($this->getReference('agent_group_annan'));
        $applicant->setName('Marc Geurts');
        $applicant->setEmail('geurtsmarc@hotmail.com');
        $applicant->setPhone('0611389156');
        $applicant->setProtection(false);
        $this->addReference('applicant_1', $applicant);
        $manager->persist($applicant);

        $applicant = new Applicant();
        $applicant->setAgentGroup($this->getReference('agent_group_annan'));
        $applicant->setName('Antica Culina');
        $applicant->setEmail('a.culina@yahoo.com');
        $applicant->setPhone('');
        $applicant->setProtection(true);
        $this->addReference('applicant_2', $applicant);
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
