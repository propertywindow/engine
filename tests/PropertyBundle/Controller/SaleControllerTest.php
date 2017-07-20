<?php declare(strict_types=1);

namespace Tests\PropertyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class SaleControllerTest
 * @package Tests\PropertyBundle\Controller
 */
class SaleControllerTest extends WebTestCase
{
    public function saleIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        //        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //        $this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());
    }
}
