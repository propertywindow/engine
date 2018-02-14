<?php
declare(strict_types = 1);

namespace PropertyBundle\DataFixtures\ORM;

use PropertyBundle\Entity\Terms;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadTermsData
 */
class LoadTermsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $terms = new Terms();
        $terms->setEn('New');
        $terms->setNl('Nieuw');
        $terms->setShowPrice(false);
        $this->setReference('term_new', $terms);
        $manager->persist($terms);

        $terms = new Terms();
        $terms->setEn('Coming soon');
        $terms->setNl('Binnenkort beschikbaar');
        $terms->setShowPrice(false);
        $this->setReference('term_coming_soon', $terms);
        $manager->persist($terms);

        $terms = new Terms();
        $terms->setEn('Fixed price');
        $terms->setNl('Vaste prijs');
        $terms->setShowPrice(true);
        $this->setReference('term_fixed_price', $terms);
        $manager->persist($terms);

        $terms = new Terms();
        $terms->setEn('Offers around');
        $terms->setNl('Bieden rond');
        $terms->setShowPrice(true);
        $this->setReference('term_offers_around', $terms);
        $manager->persist($terms);

        $terms = new Terms();
        $terms->setEn('Offers over');
        $terms->setNl('Bod over');
        $terms->setShowPrice(true);
        $this->setReference('term_offers_over', $terms);
        $manager->persist($terms);

        $terms = new Terms();
        $terms->setEn('New price');
        $terms->setNl('Prijswijziging');
        $terms->setShowPrice(true);
        $this->setReference('term_new_price', $terms);
        $manager->persist($terms);

        $terms = new Terms();
        $terms->setEn('Under offer');
        $terms->setNl('Verkocht onder voorbehoud');
        $terms->setShowPrice(false);
        $this->setReference('term_under_offer', $terms);
        $manager->persist($terms);

        $terms = new Terms();
        $terms->setEn('Retracted');
        $terms->setNl('Ingetrokken');
        $terms->setShowPrice(false);
        $this->setReference('term_retracted', $terms);
        $manager->persist($terms);

        $terms = new Terms();
        $terms->setEn('Sold');
        $terms->setNl('Verkocht');
        $terms->setShowPrice(false);
        $this->setReference('term_sold', $terms);
        $manager->persist($terms);

        $terms = new Terms();
        $terms->setEn('Rented');
        $terms->setNl('Verhuurd');
        $terms->setShowPrice(false);
        $this->setReference('term_rented', $terms);
        $manager->persist($terms);

        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}
