<?php
declare(strict_types=1);

namespace AppBundle\Repository;

use AppBundle\Entity\Acceptance;
use AppBundle\Exceptions\AcceptanceNotFoundException;
use Doctrine\ORM\EntityRepository;

/**
 * Acceptance Repository
 */
class AcceptanceRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Acceptance
     * @throws AcceptanceNotFoundException
     */
    public function findById(int $id): Acceptance
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new AcceptanceNotFoundException();
        }

        /** @var Acceptance $result */
        return $result;
    }
}
