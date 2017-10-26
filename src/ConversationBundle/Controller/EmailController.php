<?php declare(strict_types=1);

namespace ConversationBundle\Controller;

use AppBundle\Controller\BaseController;
use ConversationBundle\Entity\Email;
use ConversationBundle\Entity\Mailbox;
use ConversationBundle\Exceptions\ConversationNotFoundException;
use ConversationBundle\Exceptions\EmailNotSetException;
use Exception;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Error;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\CouldNotAuthenticateUserException;
use AppBundle\Exceptions\JsonRpc\CouldNotParseJsonRequestException;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcRequestException;
use ConversationBundle\Exceptions\NotificationNotFoundException;
use ConversationBundle\Service\Inbox\Mapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

/**
 * @Route(service="email_controller")
 */
class EmailController extends BaseController
{
    /**
     * @Route("/email" , name="email")
     *
     * @param Request $httpRequest
     *
     * @return HttpResponse
     */
    public function requestHandler(Request $httpRequest)
    {
        $id = null;
        try {
            list($id, $userId, $method, $parameters) = $this->prepareRequest($httpRequest);

            $jsonRpcResponse = Response::success($id, $this->invoke($userId, $method, $parameters));
        } catch (CouldNotParseJsonRequestException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::PARSE_ERROR, $ex->getMessage()));
        } catch (InvalidJsonRpcRequestException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::INVALID_REQUEST, $ex->getMessage()));
        } catch (InvalidJsonRpcMethodException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::METHOD_NOT_FOUND, $ex->getMessage()));
        } catch (InvalidArgumentException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::INVALID_PARAMS, $ex->getMessage()));
        } catch (CouldNotAuthenticateUserException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::USER_NOT_AUTHENTICATED, $ex->getMessage()));
        } catch (ConversationNotFoundException $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::INBOX_NOT_FOUND, $ex->getMessage()));
        } catch (Exception $ex) {
            $jsonRpcResponse = Response::failure($id, new Error(self::INTERNAL_ERROR, $ex->getMessage()));
        }

        return $this->createResponse($jsonRpcResponse);
    }

    /**
     * @param int    $userId
     * @param string $method
     * @param array  $parameters
     *
     * @return array
     * @throws InvalidJsonRpcMethodException
     * @throws NotificationNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
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

    // todo: get mail settings: https://emailsettings.firetrust.com/settings?q=test.user@gmail.com

    /**
     * @param int   $userId
     * @param array $parameters
     *
     * @return array
     *
     * @throws EmailNotSetException
     */
    private function getMailbox(int $userId, array $parameters)
    {
        if (!array_key_exists('mailbox', $parameters) && $parameters['mailbox'] !== null) {
            throw new InvalidArgumentException("mailbox parameter not provided");
        }

        $userSettings = $this->userSettingsService->getSettings($userId);

        if (!$userSettings->getIMAPAddress()) {
            throw new EmailNotSetException($userId);
        }

        $mailbox    = [];
        $connection = imap_open(
            $parameters['mailbox'],
            $userSettings->getIMAPUsername(),
            $userSettings->getIMAPPassword()
        );
        $emails     = imap_search($connection, 'ALL');
        $iCheck     = imap_check($connection);

        if ($emails) {
            rsort($emails);
            foreach ($emails as $e) {
                $overview = imap_fetch_overview($connection, $e.':'.$iCheck->Nmsgs, 0);

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
     *
     * @throws EmailNotSetException
     */
    private function getMailboxes(int $userId)
    {
        $userSettings = $this->userSettingsService->getSettings($userId);

        if (!$userSettings->getIMAPAddress()) {
            throw new EmailNotSetException($userId);
        }

        $server = '{'
                  .$userSettings->getIMAPAddress().':'
                  .$userSettings->getIMAPPort().'/'
                  .strtolower($userSettings->getIMAPSecure())
                  .'}';

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
}
