<?php declare(strict_types=1);

namespace AuthenticationBundle\Repository;

use AuthenticationBundle\Entity\Service;
use AuthenticationBundle\Exceptions\ServiceNotFoundException;
use Doctrine\ORM\EntityRepository;

/**
 * ServiceRepository
 *
 */
class ServiceRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Service
     *
     * @throws ServiceNotFoundException
     */
    public function findById(int $id): Service
    {
        $result = $this->find($id);

        if ($result === null) {
            throw new ServiceNotFoundException($id);
        }

        /** @var Service $result */
        return $result;
    }
}
