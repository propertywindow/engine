<?php
declare(strict_types = 1);

namespace LogBundle\Service;

use AuthenticationBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use LogBundle\Entity\Error;
use LogBundle\Exceptions\ErrorNotFoundException;
use LogBundle\Repository\ErrorRepository;

/**
 * @package LogBundle\Service
 */
class LogErrorService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ErrorRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(Error::class);
    }

    /**
     * @param int $id
     *
     * @return Error
     * @throws ErrorNotFoundException
     */
    public function getError(int $id): Error
    {
        return $this->repository->findById($id);
    }

    /**
     * @return Error[]
     */
    public function getErrors(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @param User $user
     *
     * @return Error
     */
    public function getErrorFromUser(User $user): Error
    {
        return $this->repository->findByUser($user);
    }

    /**
     * @param User   $user
     * @param string $method
     * @param string $message
     * @param array  $parameters
     *
     * @return Error
     */
    public function createError(
        User $user,
        string $method,
        string $message,
        array $parameters
    ) {
        $error = new Error();

        $error->setUser($user);
        $error->setMethod($method);
        $error->setMessage($message);
        $error->setParameters($parameters);

        $this->entityManager->persist($error);
        $this->entityManager->flush();

        return $error;
    }
}
