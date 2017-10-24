<?php declare(strict_types=1);

namespace ConversationBundle\Service;

use AuthenticationBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use LogBundle\Service\LogMailService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @package ConversationBundle\Service
 */
class MailerService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var LogMailService
     */
    private $logMailService;


    private $twig;

    /**
     * @param EntityManagerInterface $entityManger
     * @param ContainerInterface     $container
     * @param LogMailService         $logMailService
     */
    public function __construct(
        EntityManagerInterface $entityManger,
        ContainerInterface $container,
        LogMailService $logMailService
    ) {
        $this->entityManager  = $entityManger;
        $this->twig           = $container->get('twig');
        $this->logMailService = $logMailService;
    }

    /**
     * @param User   $user
     * @param string $recipient
     * @param string $template
     * @param array  $parameters
     * @param bool   $personal
     *
     * @return bool
     */
    public function sendMail(
        User $user,
        string $recipient,
        string $template,
        array $parameters,
        bool $personal = false
    ) {

        $templateRepository = $this->entityManager->getRepository('ConversationBundle:EmailTemplate');
        $template           = $templateRepository->findOneBy([
            'agent' => $user->getAgent(),
            'name'  => $template,
        ]);

        if ($personal) {
            $settingsRepository = $this->entityManager->getRepository('AuthenticationBundle:UserSettings');
            $settings           = $settingsRepository->findByUserId($user->getId());
        } else {
            $settingsRepository = $this->entityManager->getRepository('AgentBundle:AgentSettings');
            $settings           = $settingsRepository->findByAgent($user->getAgent());
        }

        $transport = \Swift_SmtpTransport::newInstance()
                                         ->setUsername($settings->getSMTPUsername())
                                         ->setPassword($settings->getSMTPPassword())
                                         ->setHost($settings->getSMTPAddress())
                                         ->setPort($settings->getSMTPPort())
                                         ->setEncryption(strtolower($settings->getSMTPSecure()));

        $mailer = \Swift_Mailer::newInstance($transport);

        //        $message = \Swift_Message::newInstance()
        //                                 ->setSubject($template->getSubject())
        //                                 ->setFrom([$settings->getEmailAddress() => $settings->getEmailName()])
        //                                 ->setTo($recipient)
        //                                 ->setBody(
        //                                     '<h1>Welcome</h1>',
        //                                     'text/html'
        //                                 );


        $message = \Swift_Message::newInstance()
                                 ->setSubject($template->getSubject())
                                 ->setFrom([$settings->getEmailAddress() => $settings->getEmailName()])
                                 ->setTo($recipient)
                                 ->setBody(
                                     $this->twig->render(
                                         $this->twig->createTemplate($template->getMessageHTML()),
                                         $parameters
                                     ),
                                     'text/html'
                                 )
                                 ->addPart(
                                     $this->twig->render(
                                         $this->twig->createTemplate($template->getMessageTXT()),
                                         $parameters
                                     ),
                                     'text/plain'
                                 );


        if ($mailer->send($message)) {
            $this->logMailService->createMail($user, $user->getAgent(), $recipient, $template->getSubject());
        }

        return true;
    }
}
