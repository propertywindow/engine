<?php
declare(strict_types=1);

namespace AppBundle\Repository;

use AppBundle\Entity\Settings;
use AppBundle\Exceptions\SettingsNotFoundException;
use Doctrine\ORM\EntityRepository;

/**
 * Settings Repository
 */
class SettingsRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Settings
     * @throws SettingsNotFoundException
     */
    public function findById(int $id): Settings
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new SettingsNotFoundException();
        }

        /** @var Settings $result */
        return $result;
    }
}
