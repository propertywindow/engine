<?php
declare(strict_types=1);

namespace ConversationBundle\Service;

use AgentBundle\Exceptions\AgentSettingsNotFoundException;
use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Exceptions\UserSettingsNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use LogBundle\Service\LogMailService;
use Twig_Environment;

/**
 * Mailer Service
 */
class MailerService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var LogMailService
     */
    private $logMailService;

    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @param EntityManagerInterface $em
     * @param Twig_Environment       $twig
     * @param LogMailService         $logMailService
     */
    public function __construct(
        EntityManagerInterface $em,
        Twig_Environment $twig,
        LogMailService $logMailService
    ) {
        $this->em             = $em;
        $this->twig           = $twig;
        $this->logMailService = $logMailService;
    }

    /**
     * @param User   $user
     * @param string $recipient
     * @param string $templateName
     * @param array  $parameters
     * @param bool   $personal
     *
     * @return bool
     * @throws AgentSettingsNotFoundException
     * @throws UserSettingsNotFoundException
     * @throws \Throwable
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Syntax
     */
    public function sendMail(
        User $user,
        string $recipient,
        string $templateName,
        array $parameters,
        bool $personal = false
    ) {
        $template = $this->em->getRepository('ConversationBundle:EmailTemplate')->findOneBy([
            'agent' => $user->getAgent(),
            'name'  => $templateName,
        ]);

        if ($personal) {
            $settings = $this->em->getRepository('AuthenticationBundle:UserSettings')->findByUser(
                $user
            );
        } else {
            $settings = $this->em->getRepository('AgentBundle:AgentSettings')->findByAgent(
                $user->getAgent()
            );
        }

        $transport = \Swift_SmtpTransport::newInstance()
                                         ->setUsername($settings->getSMTPUsername())
                                         ->setPassword($settings->getSMTPPassword())
                                         ->setHost($settings->getSMTPAddress())
                                         ->setPort($settings->getSMTPPort())
                                         ->setEncryption(strtolower($settings->getSMTPSecure()));

        $mailer  = \Swift_Mailer::newInstance($transport);
        $html    = $this->twig->createTemplate($template->getBodyHTML());
        $txt     = $this->twig->createTemplate($template->getBodyTXT());
        $message = \Swift_Message::newInstance()
                                 ->setSubject($template->getSubject())
                                 ->setFrom([$settings->getEmailAddress() => $settings->getEmailName()])
                                 ->setTo($recipient)
                                 ->setBody($html->render($parameters), 'text/html')
                                 ->addPart($txt->render($parameters), 'text/plain');

        if ($mailer->send($message)) {
            $this->logMailService->createMail($user, $user->getAgent(), $recipient, $template->getSubject());
        }

        return true;
    }
}
