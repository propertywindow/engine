<?php declare(strict_types=1);

namespace PropertyBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class SaleControllerTest
 * @package PropertyBundle\Tests\Controller
 */
class SaleControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
    }
}
