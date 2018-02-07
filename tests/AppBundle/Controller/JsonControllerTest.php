<?php
declare(strict_types=1);

namespace Tests\AppBundle\Controller;

use AppBundle\Controller\JsonController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Json Controller Test
 */
class JsonControllerTest extends WebTestCase
{
    public function testIsAuthorized()
    {
        /** @var JsonController $controller */
        $controller = $this->getMockBuilder(JsonController::class)
                           ->disableOriginalConstructor()
                           ->getMock();

        $result = $controller->convertParameters('office', 'lowercase');

//        $this->assertEquals('Lowercase', $result);

        $this->assertNull($result);

        //https://knpuniversity.com/screencast/rest/testing-phpunit
    }
}
