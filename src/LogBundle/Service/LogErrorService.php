<?php declare(strict_types=1);

namespace LogBundle\Service;

use AuthenticationBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use LogBundle\Entity\Error;
use LogBundle\Exceptions\ErrorNotFoundException;

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
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
    }

    /**
     * @param int $id
     *
     * @return Error $error
     */
    public function getError(int $id)
    {
        $repository = $this->entityManager->getRepository('LogBundle:Error');
        $error      = $repository->findById($id);

        return $error;
    }

    /**
     * @return Error[]
     */
    public function getErrors()
    {
        $repository = $this->entityManager->getRepository('LogBundle:Error');

        return $repository->findAll();
    }

    /**
     * @param User $user
     *
     * @return Error $error
     *
     * @throws ErrorNotFoundException
     */
    public function getErrorFromUser(User $user)
    {
        $repository = $this->entityManager->getRepository('LogBundle:Error');
        $error      = $repository->findByUser($user);

        return $error;
    }

    /**
     * @param User   $user
     * @param string $method
     * @param string $message
     * @param array $parameters
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
