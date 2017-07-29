<?php declare(strict_types=1);

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/")
     *
     * @return Response
     */
    public function indexAction()
    {
        if ($this->container->getParameter('kernel.environment') !== 'dev') {
            throw $this->createAccessDeniedException('You don\'t have access to this page!');
        }

        return new Response('Property Window Engine');
    }

    /**
     * @Route("/token/{userId}")
     *
     * @param int $userId
     *
     * @return Response
     */
    public function tokenAction($userId)
    {
        $repository = $this->getDoctrine()->getRepository('AuthenticationBundle:User');
        $user       = $repository->find($userId);

        $timestamp      = time();
        $secret         = $user->getUsername(); // because of md5
        $signature      = hash_hmac("sha1", $timestamp."-".$userId, $secret);
        $payload        = [
            "user"      => $userId,
            "password"  => $secret,
            "timestamp" => $timestamp,
            "signature" => $signature,
        ];
        $payloadJson    = json_encode($payload);
        $payloadEncoded = base64_encode($payloadJson);

        return new Response('Basic '.$payloadEncoded);
    }
}
