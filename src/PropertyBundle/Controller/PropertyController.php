<?php declare(strict_types=1);

namespace PropertyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class PropertyController
 * @package PropertyBundle\Controller
 */
class PropertyController extends Controller
{
    /**
     * @Route("/list", name="index")
     *
     * @return JsonResponse
     */
    public function listAction()
    {
        $propertyService = $this->container->get('property_service');
        $propertyService->listAll();

        return new JsonResponse($propertyService);
    }

    /**
     * @Route("/view/{id}", name="get")
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function viewAction($id)
    {
        $propertyService = $this->container->get('property_service');
        $propertyService->viewProperty($id);

        return new JsonResponse('view'. $id);
    }


    /**
     * @Route("/create", name="create")
     *
     * @return JsonResponse
     */
    public function createAction()
    {
        $propertyService = $this->container->get('property_service');
        $propertyService->createProperty();

        return new JsonResponse('added');
    }
}
