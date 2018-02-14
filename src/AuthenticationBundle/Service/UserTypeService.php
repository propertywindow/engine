<?php declare(strict_types = 1);

namespace AuthenticationBundle\Service;

use AuthenticationBundle\Exceptions\UserTypeNotFoundException;
use AuthenticationBundle\Repository\UserTypeRepository;
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
     * @var UserTypeRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(UserType::class);
    }

    /**
     * @param int $id
     *
     * @return UserType
     * @throws UserTypeNotFoundException
     */
    public function getUserType(int $id): UserType
    {
        return $this->repository->findById($id);
    }

    /**
     * @param bool $visible
     *
     * @return UserType[]
     */
    public function getUserTypes(bool $visible = false): array
    {
        return $this->repository->listAll($visible);
    }
}
