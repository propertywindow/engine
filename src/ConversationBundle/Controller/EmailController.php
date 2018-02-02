<?php
declare(strict_types=1);

namespace ConversationBundle\Controller;

use AppBundle\Controller\BaseController;
use AuthenticationBundle\Entity\UserSettings;
use AuthenticationBundle\Exceptions\UserNotFoundException;
use ConversationBundle\Entity\Email;
use ConversationBundle\Entity\Mailbox;
use ConversationBundle\Exceptions\EmailNotSetException;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use ConversationBundle\Service\Inbox\Mapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="ConversationBundle\Controller\EmailController")
 */
class EmailController extends BaseController
{
    /**
     * @Route("/email" , name="email")
     * @param Request $httpRequest
     *
     * @return HttpResponse
     * @throws Throwable
     */
    public function requestHandler(Request $httpRequest)
    {
        try {
            list($userId, $method, $parameters) = $this->prepareRequest($httpRequest);
            $jsonRpcResponse = Response::success($this->invoke($userId, $method, $parameters));
        } catch (Throwable $throwable) {
            $jsonRpcResponse = $this->throwable($throwable, $httpRequest);
        }

        return $this->createResponse($jsonRpcResponse);
    }

    /**
     * @param int    $userId
     * @param string $method
     * @param array  $parameters
     *
     * @return array
     * @throws EmailNotSetException
     * @throws InvalidJsonRpcMethodException
     * @throws UserNotFoundException
     */
    private function invoke(int $userId, string $method, array $parameters = [])
    {
        switch ($method) {
            case "getMailbox":
                return $this->getMailbox($userId, $parameters);
            case "getMailboxes":
                return $this->getMailboxes($userId);
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     * @throws EmailNotSetException
     * @throws UserNotFoundException
     */
    private function getMailbox(int $userId, array $parameters)
    {
        $this->checkParameters([
            'mailbox',
        ], $parameters);

        $user         = $this->userService->getUser($userId);
        $userSettings = $user->getSettings();

        $this->checkMailbox($userSettings);

        $mailbox    = [];
        $connection = imap_open(
            $parameters['mailbox'],
            $userSettings->getIMAPUsername(),
            $userSettings->getIMAPPassword()
        );
        $emails     = imap_search($connection, 'ALL');
        $iCheck     = imap_check($connection);

        if (!empty($emails)) {
            rsort($emails);
            foreach ($emails as $e) {
                $overview = imap_fetch_overview($connection, $e . ':' . $iCheck->Nmsgs, 0);

                $email = new Email();

                $email->setId($overview[0]->msgno);
                $email->setSubject($overview[0]->subject);
                $email->setFrom($overview[0]->from);
                $email->setDate($overview[0]->date);
                $email->setMessage(imap_body($connection, $e, 2));

                $mailbox[] = $email;
            }
        }

        imap_close($connection);

        return Mapper::fromMailbox(...$mailbox);
    }

    /**
     * @param int $userId
     *
     * @return array
     * @throws EmailNotSetException
     * @throws UserNotFoundException
     */
    private function getMailboxes(int $userId)
    {
        $user         = $this->userService->getUser($userId);
        $userSettings = $user->getSettings();

        $this->checkMailbox($userSettings);

        $server = '{'
                  . $userSettings->getIMAPAddress() . ':'
                  . $userSettings->getIMAPPort() . '/'
                  . strtolower($userSettings->getIMAPSecure())
                  . '}';

        $connection = imap_open(
            $server,
            $userSettings->getIMAPUsername(),
            $userSettings->getIMAPPassword()
        );

        $mailboxes = [];
        $list      = imap_list($connection, $server, '*');

        foreach ($list as $item) {
            $array = [];
            if (preg_match('/}/i', $item)) {
                $array = explode('}', $item);
            }
            if (preg_match('/]/i', $item)) {
                $array = explode(']/', $item);
            }

            $mailbox    = new Mailbox();
            $folderName = str_replace('INBOX.', '', trim(stripslashes($array[1])));

            $mailbox->setName(ucwords(strtolower(imap_utf7_decode($folderName))));
            $mailbox->setMailbox($item);
            $mailbox->setUnread(0);

            $mailboxes[] = $mailbox;
        }

        imap_close($connection);

        return Mapper::fromMailboxes(...$mailboxes);
    }

    /**
     * @param UserSettings $userSettings
     *
     * @throws EmailNotSetException
     */
    private function checkMailbox($userSettings)
    {
        if ($userSettings->getIMAPAddress() === null ||
            $userSettings->getIMAPPort() === null ||
            $userSettings->getIMAPSecure() === null ||
            $userSettings->getIMAPUsername() === null ||
            $userSettings->getIMAPPassword() === null
        ) {
            throw new EmailNotSetException();
        }
    }
}
