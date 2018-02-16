<?php
declare(strict_types = 1);

namespace AlertBundle\DataFixtures\ORM;

use AlertBundle\Entity\Applicant;
use AlertBundle\Entity\Application;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Load Application Data
 */
class LoadApplicationData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $application = new Application();
        /** @var Applicant $applicant */
        $applicant = $this->getReference('applicant_1');
        $application->setApplicant($applicant);
        $application->setKind($this->getReference('kind_sale'));
        $application->setPostcode('5754DW');
        $application->setCountry('NL');
        $application->setDistance(15);
        $application->setMinPrice(150000);
        $application->setMaxPrice(450000);
        $application->setRooms(3);
        $application->setSubType($this->getReference('sub_type_detached_house'));
        $application->setTerms($this->getReference('term_fixed_price'));
        $application->setActive(true);
        $this->setReference('application_1', $application);
        $manager->persist($application);

        $application = new Application();
        /** @var Applicant $applicant */
        $applicant = $this->getReference('applicant_1');
        $application->setApplicant($applicant);
        $application->setKind($this->getReference('kind_sale'));
        $application->setPostcode('5754DW');
        $application->setCountry('NL');
        $application->setDistance(30);
        $application->setMinPrice(350000);
        $application->setMaxPrice(650000);
        $application->setRooms(5);
        $application->setSubType($this->getReference('sub_type_detached_house'));
        $application->setTerms();
        $application->setActive(true);
        $this->setReference('application_2', $application);
        $manager->persist($application);

        $application = new Application();
        /** @var Applicant $applicant */
        $applicant = $this->getReference('applicant_2');
        $application->setApplicant($applicant);
        $application->setKind($this->getReference('kind_sale'));
        $application->setPostcode('6702CR');
        $application->setCountry('NL');
        $application->setDistance(15);
        $application->setMinPrice(150000);
        $application->setMaxPrice(450000);
        $application->setRooms(3);
        $application->setSubType($this->getReference('sub_type_second_floor_flat'));
        $application->setTerms($this->getReference('term_offers_around'));
        $application->setActive(true);
        $this->setReference('application_3', $application);
        $manager->persist($application);

        $application = new Application();
        /** @var Applicant $applicant */
        $applicant = $this->getReference('applicant_3');
        $application->setApplicant($applicant);
        $application->setKind($this->getReference('kind_sale'));
        $application->setPostcode('EH15 1DE');
        $application->setCountry('GB');
        $application->setDistance(5);
        $application->setMinPrice(90000);
        $application->setMaxPrice(450000);
        $application->setActive(true);
        $this->setReference('application_4', $application);
        $manager->persist($application);


        $manager->flush();
    }


    /**
     * @return integer
     */
    public function getOrder()
    {
        return 61;
    }
}
