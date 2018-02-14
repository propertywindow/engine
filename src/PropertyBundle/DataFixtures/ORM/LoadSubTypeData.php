<?php
declare(strict_types = 1);

namespace PropertyBundle\DataFixtures\ORM;

use PropertyBundle\Entity\SubType;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadSubTypeData
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
        $this->setReference('sub_type_cottage', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_house'));
        $subType->setEn('Detached Bungalow');
        $subType->setNl('Vrijstaande Bungalow');
        $this->setReference('sub_type_detached_bungalow', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_house'));
        $subType->setEn('Detached House');
        $subType->setNl('Vrijstaand Huis');
        $this->setReference('sub_type_detached_house', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_house'));
        $subType->setEn('End Terraced House');
        $subType->setNl('Hoekwoning');
        $this->setReference('sub_type_end_terraced_house', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_house'));
        $subType->setEn('House Others');
        $subType->setNl('Huis Overige');
        $this->setReference('sub_type_house_others', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_house'));
        $subType->setEn('House With Land Over One Acre');
        $subType->setNl('Huis met meer dan een hectare grond');
        $this->setReference('sub_type_house_with_land_over_one_acre', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_house'));
        $subType->setEn('Linked Bungalow');
        $subType->setNl('Gekoppelde bungalow');
        $this->setReference('sub_type_linked_bungalow', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_house'));
        $subType->setEn('Mews House');
        $subType->setNl('Vakantie Huis');
        $this->setReference('sub_type_mews_house', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_house'));
        $subType->setEn('Semi-Detached Bungalow');
        $subType->setNl('Twee onder een kap Bungalow');
        $this->setReference('sub_type_semi_detached_bungalow', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_house'));
        $subType->setEn('Semi-Detached House ');
        $subType->setNl('Twee onder een kap Woning');
        $this->setReference('sub_type_semi_detached_house', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_house'));
        $subType->setEn('Terraced Bungalow');
        $subType->setNl('Rijtjes Bungalow');
        $this->setReference('sub_type_terraced_bungalow', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_house'));
        $subType->setEn('Terraced House');
        $subType->setNl('Rijtjeshuis');
        $this->setReference('sub_type_terraced_house', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_house'));
        $subType->setEn('Townhouse');
        $subType->setNl('Stadswoning');
        $this->setReference('sub_type_townhouse', $subType);
        $manager->persist($subType);

        // Flats
        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Basement Flat');
        $subType->setNl('Cottage');
        $this->setReference('sub_type_basement_flat', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Double Upper Flat');
        $subType->setNl('Maisonnette');
        $this->setReference('sub_type_double_upper_flat', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Duplex');
        $subType->setNl('Duplex');
        $this->setReference('sub_type_duplex', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Fifth Floor Flat');
        $subType->setNl('5de Verdieping Flat');
        $this->setReference('sub_type_fifth_floor_flat', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('First And Ground Floor Flat');
        $subType->setNl('Maisonnette');
        $this->setReference('sub_type_first_and_ground_floor_flat', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('First Floor Flat');
        $subType->setNl('Eerste Verdieping Flat');
        $this->setReference('sub_type_first_floor_flat', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Flat (Others)');
        $subType->setNl('Flat Overige');
        $this->setReference('sub_type_flat_others', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Fourth Floor Flat');
        $subType->setNl('Cottage');
        $this->setReference('sub_type_fourth_floor_flat', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Garden And Ground Floor Flat');
        $subType->setNl('Cottage');
        $this->setReference('sub_type_garden_and_ground_floor_flat', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Garden Flat');
        $subType->setNl('Cottage');
        $this->setReference('sub_type_garden_flat', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Ground Floor Flat');
        $subType->setNl('Cottage');
        $this->setReference('sub_type_ground_floor_flat', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Lower Flat');
        $subType->setNl('Cottage');
        $this->setReference('sub_type_lower_flat', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Lower Ground Floor Flat');
        $subType->setNl('Cottage');
        $this->setReference('sub_type_lower_ground_floor_flat', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Lower Villa');
        $subType->setNl('Onder Villa Flat');
        $this->setReference('sub_type_lower_villa', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Maindoor Flat');
        $subType->setNl('Begane Vloer Flat');
        $this->setReference('sub_type_maindoor_flat', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Maisonette Flat');
        $subType->setNl('Maisonette');
        $this->setReference('sub_type_maisonette_flat', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Mews Flat');
        $subType->setNl('Vakantie Flat');
        $this->setReference('sub_type_mews_flat', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Penthouse Flat');
        $subType->setNl('Penthouse');
        $this->setReference('sub_type_penthouse_flat', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Second Floor Flat');
        $subType->setNl('2de Verdieping Flat');
        $this->setReference('sub_type_second_floor_flat', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Sixth Floor Flat');
        $subType->setNl('6de Verdieping Flat');
        $this->setReference('sub_type_sixth_floor_flat', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Studio Flat');
        $subType->setNl('Studio');
        $this->setReference('sub_type_studio_flat', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Third Floor Flat');
        $subType->setNl('3de Verdieping Flat');
        $this->setReference('sub_type_third_floor_flat', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Top Floor Flat');
        $subType->setNl('Bovenste Verdieping Flat');
        $this->setReference('sub_type_top_floor_flat', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Triplex');
        $subType->setNl('Triplex');
        $this->setReference('sub_type_triplex', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Upper Flat');
        $subType->setNl('Boven Flat');
        $this->setReference('sub_type_upper_flat', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_flat'));
        $subType->setEn('Upper Villa');
        $subType->setNl('Boven Villa Flat');
        $this->setReference('sub_type_upper_villa', $subType);
        $manager->persist($subType);

        // Other
        $subType = new SubType();
        $subType->setType($this->getReference('type_other'));
        $subType->setEn('Commercial');
        $subType->setNl('Commercieel');
        $this->setReference('sub_type_commercial', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_other'));
        $subType->setEn('Lock-ups and Car Parking');
        $subType->setNl('Opslag en Parkeerplaats');
        $this->setReference('sub_type_lock_ups_and_car_parking', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_other'));
        $subType->setEn('New Build');
        $subType->setNl('Nieuwbouw');
        $this->setReference('sub_type_new_build', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_other'));
        $subType->setEn('Retirement');
        $subType->setNl('Pensioen Huis');
        $this->setReference('sub_type_retirement', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_other'));
        $subType->setEn('Single House Plot');
        $subType->setNl('Grond voor Huis');
        $this->setReference('sub_type_single_house_plot', $subType);
        $manager->persist($subType);

        $subType = new SubType();
        $subType->setType($this->getReference('type_other'));
        $subType->setEn('Timeshare');
        $subType->setNl('Timeshare');
        $this->setReference('sub_type_timeshare', $subType);
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
