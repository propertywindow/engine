<?php declare(strict_types=1);

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class DefaultControllerTest
 * @package Tests\AppBundle\Controller
 */
class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

//        static::assertEquals(500, $client->getResponse()->getStatusCode());
//        static::assertContains('You don\'t have access to this page!', $crawler->text());
        static::assertContains('Property Window Engine', $crawler->text());
    }
}
