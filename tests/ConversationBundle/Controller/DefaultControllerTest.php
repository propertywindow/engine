<?php declare(strict_types=1);

namespace Tests\ConverstationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class DefaultControllerTest
 * @package Tests\ConverstationBundle\Controller
 */
class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/conversation/');

        static::assertEquals(200, $client->getResponse()->getStatusCode());
        static::assertContains('conversations', $crawler->text());
    }
}
