<?php declare(strict_types=1);

namespace AuthenticationBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use AuthenticationBundle\Entity\UserType;

/**
 * @package AuthenticationBundle\Service
 */
class UserTypeService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
    }


    /**
     * @param int $id
     *
     * @return UserType $userType
     */
    public function getUserType(int $id)
    {
        $repository = $this->entityManager->getRepository('AuthenticationBundle:UserType');
        $userType   = $repository->findById($id);

        return $userType;
    }

    /**
     * @param bool $visible
     *
     * @return UserType[] $userTypes
     *
     */
    public function getUserTypes(bool $visible = false)
    {
        $repository = $this->entityManager->getRepository('AuthenticationBundle:UserType');
        $userTypes = $repository->listAll($visible);

        return $userTypes;
    }
}
