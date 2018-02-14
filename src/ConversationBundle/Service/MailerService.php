<?php
declare(strict_types = 1);

namespace ConversationBundle\Service;

use AgentBundle\Entity\AgentSettings;
use AgentBundle\Exceptions\AgentSettingsNotFoundException;
use AgentBundle\Repository\AgentSettingsRepository;
use AuthenticationBundle\Entity\User;
use AuthenticationBundle\Entity\UserSettings;
use AuthenticationBundle\Exceptions\UserSettingsNotFoundException;
use AuthenticationBundle\Repository\UserSettingsRepository;
use ConversationBundle\Entity\EmailTemplate;
use ConversationBundle\Repository\EmailTemplateRepository;
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
    private $entityManager;

    /**
     * @var LogMailService
     */
    private $logMailService;

    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @var AgentSettingsRepository
     */
    private $agentRepository;

    /**
     * @var UserSettingsRepository
     */
    private $userRepository;

    /**
     * @var EmailTemplateRepository
     */
    private $templateRepository;

    /**
     * @param EntityManagerInterface $entityManger
     * @param Twig_Environment       $twig
     * @param LogMailService         $logMailService
     */
    public function __construct(
        EntityManagerInterface $entityManger,
        Twig_Environment $twig,
        LogMailService $logMailService
    ) {
        $this->entityManager      = $entityManger;
        $this->twig               = $twig;
        $this->logMailService     = $logMailService;
        $this->agentRepository    = $this->entityManager->getRepository(AgentSettings::class);
        $this->userRepository     = $this->entityManager->getRepository(UserSettings::class);
        $this->templateRepository = $this->entityManager->getRepository(EmailTemplate::class);
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

        /** @var EmailTemplate $template */
        $template = $this->templateRepository->findOneBy([
            'agent' => $user->getAgent(),
            'name'  => $templateName,
        ]);

        if ($personal) {
            $settings = $this->userRepository->findByUser($user);
        } else {
            $settings = $this->agentRepository->findByAgent($user->getAgent());
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
