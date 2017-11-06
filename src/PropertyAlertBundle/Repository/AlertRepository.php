<?php declare(strict_types=1);

namespace PropertyAlertBundle\Repository;

use Doctrine\ORM\EntityRepository;
use PropertyAlertBundle\Entity\Alert;
use PropertyAlertBundle\Exceptions\AlertNotFoundException;

/**
 * AlertRepository
 */
class AlertRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Alert
     *
     * @throws AlertNotFoundException
     */
    public function findById(int $id): Alert
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new AlertNotFoundException($id);
        }

        /** @var Alert $result */
        return $result;
    }
}
