<?php declare(strict_types=1);

namespace PropertyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class LetController
 * @package PropertyBundle\Controller
 */
class LetController extends Controller
{
    /**
     * @Route("/let")
     */
    public function LetAction()
    {
        return new JsonResponse('Sale');
    }
}
