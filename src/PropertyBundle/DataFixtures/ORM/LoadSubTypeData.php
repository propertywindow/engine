<?php declare(strict_types=1);

namespace PropertyBundle\DataFixtures\ORM;

use PropertyBundle\Entity\SubType;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadSubTypeData
 * @package PropertyBundle\DataFixtures\ORM
 */
class LoadSubTypeData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Houses
        $subType = new SubType();
        $subType->setType($this->getReference('type_house'));
        $subType->setEn('Cottage');
        $subType->setNl('Cottage');
        $manager->persist($subType);
        
        $subType = new SubType();
        $subType->setType($this->getReference('type_house'));
        $subType->setEn('Detached Bungalow');
        $subType->setNl('Vrijstaande Bungalow');
        $manager->persist($subType);
        
        $subType = new SubType();
        $subType->setType($this->getReference('type_house'));
        $subType->setEn('Detached House');
        $subType->setNl('Vrijstaand Huis');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_house'));
        $subType->setEn('End Terraced House');
        $subType->setNl('Hoekwoning');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_house'));
        $subType->setEn('House Others');
        $subType->setNl('Huis Overige');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_house'));
        $subType->setEn('House With Land Over One Acre');
        $subType->setNl('Huis met meer dan een hectare grond');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_house'));
        $subType->setEn('Linked Bungalow');
        $subType->setNl('Gekoppelde bungalow');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_house'));
        $subType->setEn('Mews House');
        $subType->setNl('Vakantie Huis');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_house'));
        $subType->setEn('Semi-Detached Bungalow');
        $subType->setNl('Twee onder een kap Bungalow');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_house'));
        $subType->setEn('Semi-Detached House ');
        $subType->setNl('Twee onder een kap Woning');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_house'));
        $subType->setEn('Terraced Bungalow');
        $subType->setNl('Rijtjes Bungalow');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_house'));
        $subType->setEn('Terraced House');
        $subType->setNl('Rijtjeshuis');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_house'));
        $subType->setEn('Townhouse');
        $subType->setNl('Stadswoning');
        $manager->persist($subType);

        // Flats
        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Basement Flat');
        $subType->setNl('Cottage');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Double Upper Flat');
        $subType->setNl('Maisonnette');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Duplex');
        $subType->setNl('Duplex');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Fifth Floor Flat');
        $subType->setNl('5de Verdieping Flat');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('First And Ground Floor Flat');
        $subType->setNl('Maisonnette');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('First Floor Flat');
        $subType->setNl('Eerste Verdieping Flat');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Flat (Others)');
        $subType->setNl('Flat Overige');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Fourth Floor Flat');
        $subType->setNl('Cottage');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Garden And Ground Floor Flat');
        $subType->setNl('Cottage');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Garden Flat');
        $subType->setNl('Cottage');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Ground Floor Flat');
        $subType->setNl('Cottage');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Lower Flat');
        $subType->setNl('Cottage');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Lower Ground Floor Flat');
        $subType->setNl('Cottage');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Lower Villa');
        $subType->setNl('Onder Villa Flat');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Maindoor Flat');
        $subType->setNl('Begane Vloer Flat');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Maisonette Flat');
        $subType->setNl('Maisonette');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Mews Flat');
        $subType->setNl('Vakantie Flat');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Penthouse Flat');
        $subType->setNl('Penthouse');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Second Floor Flat');
        $subType->setNl('2de Verdieping Flat');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Sixth Floor Flat');
        $subType->setNl('6de Verdieping Flat');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Studio Flat');
        $subType->setNl('Studio');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Third Floor Flat');
        $subType->setNl('3de Verdieping Flat');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Top Floor Flat');
        $subType->setNl('Bovenste Verdieping Flat');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Triplex');
        $subType->setNl('Triplex');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Upper Flat');
        $subType->setNl('Boven Flat');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Upper Villa');
        $subType->setNl('Boven Villa Flat');
        $manager->persist($subType);

        // Other
        $subType = new SubType();
        $subType->setType($this->getReference('type_other'));
        $subType->setEn('Commercial');
        $subType->setNl('Commercieel');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_other'));
        $subType->setEn('Lock-ups and Car Parking');
        $subType->setNl('Opslag en Parkeerplaats');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_other'));
        $subType->setEn('New Build');
        $subType->setNl('Nieuwbouw');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_other'));
        $subType->setEn('Retirement');
        $subType->setNl('Pensioen Huis');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_other'));
        $subType->setEn('Single House Plot');
        $subType->setNl('Grond voor Huis');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_other'));
        $subType->setEn('Timeshare');
        $subType->setNl('Timeshare');
        $manager->persist($subType);

        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 3;
    }
}
