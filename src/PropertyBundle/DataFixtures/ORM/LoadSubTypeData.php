<?php declare(strict_types=1);

namespace PropertyBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PropertyBundle\Entity\SubType;

/**
 * Class LoadSubTypeData
 * @package PropertyBundle\DataFixtures\ORM
 */
class LoadSubTypeData implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Houses
        $subType = new SubType();
        $subType->setTypeId(1);
        $subType->setEn('Cottage');
        $subType->setNl('Cottage');
        $manager->persist($subType);
        
        $subType = new SubType();
        $subType->setTypeId(1);
        $subType->setEn('Detached Bungalow');
        $subType->setNl('Vrijstaande Bungalow');
        $manager->persist($subType);
        
        $subType = new SubType();
        $subType->setTypeId(1);
        $subType->setEn('Detached House');
        $subType->setNl('Vrijstaand Huis');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(1);
        $subType->setEn('End Terraced House');
        $subType->setNl('Hoekwoning');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(1);
        $subType->setEn('House Others');
        $subType->setNl('Huis Overige');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(1);
        $subType->setEn('House With Land Over One Acre');
        $subType->setNl('Huis met meer dan een hectare grond');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(1);
        $subType->setEn('Linked Bungalow');
        $subType->setNl('Gekoppelde bungalow');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(1);
        $subType->setEn('Mews House');
        $subType->setNl('Vakantie Huis');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(1);
        $subType->setEn('Semi-Detached Bungalow');
        $subType->setNl('Twee onder een kap Bungalow');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(1);
        $subType->setEn('Semi-Detached House ');
        $subType->setNl('Twee onder een kap Woning');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(1);
        $subType->setEn('Terraced Bungalow');
        $subType->setNl('Rijtjes Bungalow');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(1);
        $subType->setEn('Terraced House');
        $subType->setNl('Rijtjeshuis');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(1);
        $subType->setEn('Townhouse');
        $subType->setNl('Stadswoning');
        $manager->persist($subType);

        // Flats
        $subType = new SubType();
        $subType->setTypeId(2);
        $subType->setEn('Basement Flat');
        $subType->setNl('Cottage');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(2);
        $subType->setEn('Double Upper Flat');
        $subType->setNl('Maisonnette');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(2);
        $subType->setEn('Duplex');
        $subType->setNl('Duplex');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(2);
        $subType->setEn('Fifth Floor Flat');
        $subType->setNl('5de Verdieping Flat');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(2);
        $subType->setEn('First And Ground Floor Flat');
        $subType->setNl('Maisonnette');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(2);
        $subType->setEn('First Floor Flat');
        $subType->setNl('Eerste Verdieping Flat');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(2);
        $subType->setEn('Flat (Others)');
        $subType->setNl('Flat Overige');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(2);
        $subType->setEn('Fourth Floor Flat');
        $subType->setNl('Cottage');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(2);
        $subType->setEn('Garden And Ground Floor Flat');
        $subType->setNl('Cottage');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(2);
        $subType->setEn('Garden Flat');
        $subType->setNl('Cottage');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(2);
        $subType->setEn('Ground Floor Flat');
        $subType->setNl('Cottage');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(2);
        $subType->setEn('Lower Flat');
        $subType->setNl('Cottage');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(2);
        $subType->setEn('Lower Ground Floor Flat');
        $subType->setNl('Cottage');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(2);
        $subType->setEn('Lower Villa');
        $subType->setNl('Onder Villa Flat');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(2);
        $subType->setEn('Maindoor Flat');
        $subType->setNl('Begane Vloer Flat');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(2);
        $subType->setEn('Maisonette Flat');
        $subType->setNl('Maisonette');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(2);
        $subType->setEn('Mews Flat');
        $subType->setNl('Vakantie Flat');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(2);
        $subType->setEn('Penthouse Flat');
        $subType->setNl('Penthouse');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(2);
        $subType->setEn('Second Floor Flat');
        $subType->setNl('2de Verdieping Flat');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(2);
        $subType->setEn('Sixth Floor Flat');
        $subType->setNl('6de Verdieping Flat');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(2);
        $subType->setEn('Studio Flat');
        $subType->setNl('Studio');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(2);
        $subType->setEn('Third Floor Flat');
        $subType->setNl('3de Verdieping Flat');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(2);
        $subType->setEn('Top Floor Flat');
        $subType->setNl('Bovenste Verdieping Flat');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(2);
        $subType->setEn('Triplex');
        $subType->setNl('Triplex');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(2);
        $subType->setEn('Upper Flat');
        $subType->setNl('Boven Flat');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(2);
        $subType->setEn('Upper Villa');
        $subType->setNl('Boven Villa Flat');
        $manager->persist($subType);

        // Other
        $subType = new SubType();
        $subType->setTypeId(3);
        $subType->setEn('Commercial');
        $subType->setNl('Commercieel');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(3);
        $subType->setEn('Lock-ups and Car Parking');
        $subType->setNl('Opslag en Parkeerplaats');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(3);
        $subType->setEn('New Build');
        $subType->setNl('Nieuwbouw');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(3);
        $subType->setEn('Retirement');
        $subType->setNl('Pensioen Huis');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(3);
        $subType->setEn('Single House Plot');
        $subType->setNl('Grond voor Huis');
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setTypeId(3);
        $subType->setEn('Timeshare');
        $subType->setNl('Timeshare');
        $manager->persist($subType);

        $manager->flush();
    }
}
