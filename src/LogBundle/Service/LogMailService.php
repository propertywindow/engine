<?php
declare(strict_types=1);

namespace LogBundle\Service;

use AgentBundle\Entity\Agent;
use AuthenticationBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use LogBundle\Entity\Mail;
use LogBundle\Exceptions\MailNotFoundException;
use LogBundle\Repository\MailRepository;

/**
 * LogMail Service
 */
class LogMailService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var MailRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface $entityManger
     */
    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
        $this->repository    = $this->entityManager->getRepository(Mail::class);
    }

    /**
     * @param int $id
     *
     * @return Mail $mail
     * @throws MailNotFoundException
     */
    public function getMail(int $id): Mail
    {
        $mail = $this->repository->find($id);

        /** @var Mail $mail */
        if ($mail === null) {
            throw new MailNotFoundException($id);
        }

        return $mail;
    }

    /**
     * @param User   $user
     * @param Agent  $agent
     * @param string $recipient
     * @param string $subject
     *
     * @return Mail
     */
    public function createMail(
        User $user,
        Agent $agent,
        string $recipient,
        string $subject
    ) {
        $mail = new Mail();

        $mail->setSender($user);
        $mail->setAgent($agent);
        $mail->setRecipient($recipient);
        $mail->setSubject($subject);

        $this->entityManager->persist($mail);
        $this->entityManager->flush();

        return $mail;
    }
}
