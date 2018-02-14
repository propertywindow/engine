<?php
declare(strict_types = 1);

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Acceptance;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadAcceptanceData
 */
class LoadAcceptanceData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $acceptance = new Acceptance();
        $acceptance->setEn('Accepted');
        $acceptance->setNl('Geaccepteerd');
        $this->setReference('acceptance_accepted', $acceptance);
        $manager->persist($acceptance);

        $acceptance = new Acceptance();
        $acceptance->setEn('Rejected');
        $acceptance->setNl('Afgewezen');
        $this->setReference('acceptance_rejected', $acceptance);
        $manager->persist($acceptance);

        $acceptance = new Acceptance();
        $acceptance->setEn('Withdrawn');
        $acceptance->setNl('Teruggetrokken');
        $this->setReference('acceptance_withdrawn', $acceptance);
        $manager->persist($acceptance);

        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 6;
    }
}
