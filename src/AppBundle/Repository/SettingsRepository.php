<?php declare(strict_types=1);

namespace AppBundle\Repository;

use AppBundle\Entity\Settings;
use AppBundle\Exceptions\SettingsNotFoundException;
use Doctrine\ORM\EntityRepository;

/**
 * SettingsRepository
 */
class SettingsRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Settings
     * @throws SettingsNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function findById(int $id): Settings
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new SettingsNotFoundException($id);
        }

        /** @var Settings $result */
        return $result;
    }
}
