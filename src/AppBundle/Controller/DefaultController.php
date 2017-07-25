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
     * @Route("/token")
     *
     */
    public function tokenAction()
    {
        $userId         = 1;
        $timestamp      = time();
        $secret         = '1874Hearts!';
        $signature      = hash_hmac("sha1", $timestamp."-".$userId, $secret);
        $payload        = [
            "user"      => $userId,
            "api"       => $secret,
            "timestamp" => $timestamp,
            "signature" => $signature,
        ];
        $payloadJson    = json_encode($payload);
        $payloadEncoded = base64_encode($payloadJson);

        return new Response('Basic ' . $payloadEncoded);
    }
}
