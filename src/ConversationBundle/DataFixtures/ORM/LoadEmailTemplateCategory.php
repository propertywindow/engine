<?php declare(strict_types=1);

namespace ConversationBundle\DataFixtures\ORM;

use ConversationBundle\Entity\EmailTemplateCategory;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadEmailTemplateCategory
 * @package ConversationBundle\DataFixtures\ORM
 */
class LoadEmailTemplateCategory extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        $emailTemplateCategory = new EmailTemplateCategory();
        $emailTemplateCategory->setCategory('User');
        $emailTemplateCategory->setActive(true);
        $this->addReference('email_template_category_user', $emailTemplateCategory);
        $manager->persist($emailTemplateCategory);

        $emailTemplateCategory = new EmailTemplateCategory();
        $emailTemplateCategory->setCategory('offer');
        $emailTemplateCategory->setActive(true);
        $this->addReference('email_template_category_offer', $emailTemplateCategory);
        $manager->persist($emailTemplateCategory);

        $emailTemplateCategory = new EmailTemplateCategory();
        $emailTemplateCategory->setCategory('viewing');
        $emailTemplateCategory->setActive(true);
        $this->addReference('email_template_category_viewing', $emailTemplateCategory);
        $manager->persist($emailTemplateCategory);

        $emailTemplateCategory = new EmailTemplateCategory();
        $emailTemplateCategory->setCategory('appointment');
        $emailTemplateCategory->setActive(true);
        $this->addReference('email_template_category_appointment', $emailTemplateCategory);
        $manager->persist($emailTemplateCategory);

        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 40;
    }
}
