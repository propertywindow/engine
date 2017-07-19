<?php declare(strict_types=1);

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     *
     * @return JsonResponse
     */
    public function indexAction()
    {
        return new JsonResponse('no-access');
    }


    /**
     * @Route("/blaat", name="blaat")
     *
     * @return JsonResponse
     */
    public function blaatAction()
    {
        return new JsonResponse('no-sdfsdf');
    }

}
