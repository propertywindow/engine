<?php
declare(strict_types=1);

namespace AuthenticationBundle\Controller;

use AppBundle\Controller\BaseController;
use AuthenticationBundle\Service\Menu\Mapper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Models\JsonRpc\Response;
use AppBundle\Exceptions\JsonRpc\InvalidJsonRpcMethodException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

/**
 * @Route(service="AuthenticationBundle\Controller\MenuController")
 */
class MenuController extends BaseController
{
    /**
     * @Route("/services/menu" , name="menu")
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
     * @throws InvalidJsonRpcMethodException
     */
    private function invoke(int $userId, string $method, array $parameters = [])
    {
        switch ($method) {
            case "getMenu":
                return $this->getMenu($userId);
        }

        throw new InvalidJsonRpcMethodException("Method $method does not exist");
    }

    /**
     * @param int $userId
     *
     * @return array
     */
    private function getMenu(int $userId)
    {
        $user         = $this->userService->getUser($userId);
        $userSettings = $this->userSettingsService->getSettings($user);
        $services     = $this->serviceMapService->getAuthorizedServiceGroups($user);

        return Mapper::fromMenus($userSettings->getLanguage(), ...$services);
    }
}
