<?php declare(strict_types=1);

namespace AuthenticationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserController
 * @package AuthenticationBundle\Controller
 */
class UserController extends Controller
{
    /**
     * @Route("/user")
     */
    public function indexAction()
    {
        return new Response('user-controller');
    }
}
