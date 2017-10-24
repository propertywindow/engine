<?php declare(strict_types=1);

namespace LogBundle\Service;

use AgentBundle\Entity\Agent;
use AuthenticationBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use LogBundle\Entity\Mail;
use LogBundle\Exceptions\MailNotFoundException;

/**
 * @package LogBundle\Service
 */
class LogMailService
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
     * @return Mail $mail
     *
     * @throws MailNotFoundException
     */
    public function getMail(int $id)
    {
        $repository = $this->entityManager->getRepository('LogBundle:Mail');
        $mail      = $repository->find($id);

        /** @var Mail $mail */
        if ($mail === null) {
            throw new MailNotFoundException($id);
        }

        return $mail;
    }

    /**
     * @param User   $user
     * @param Agent  $agent
     * @param string $sendTo
     * @param string $subject
     *
     * @return Mail
     */
    public function createMail(
        User $user,
        Agent $agent,
        string $sendTo,
        string $subject
    ) {
        $mail = new Mail();

        $mail->setSendBy($user);
        $mail->setAgent($agent);
        $mail->setSentTo($sendTo);
        $mail->setSubject($subject);

        $this->entityManager->persist($mail);
        $this->entityManager->flush();

        return $mail;
    }
}
