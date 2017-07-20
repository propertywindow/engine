<?php declare(strict_types=1);

namespace PropertyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class SaleController
 * @package PropertyBundle\Controller
 */
class SaleController extends Controller
{
    /**
     * @Route("/sale")
     */
    public function saleAction()
    {
        return new JsonResponse('Sale');
    }
}
