<?php
declare(strict_types = 1);

namespace Tests\AuthenticationBundle\Controller;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * UserController Test
 */
class UserControllerTest extends WebTestCase
{
    /**
     * @var string
     */
    protected $baseUrl = 'https://engine.propertywindow.nl';

    /**
     * @param string $email
     * @param string $password
     *
     * @return string|null
     */
    public function authorize($email = 'geurtsmarc@hotmail.com', $password = 'marc')
    {
        $client = new Client([
            'base_uri' => $this->baseUrl,
            'headers'  => [
                'Content-Type' => 'application/json',
            ],
        ]);

        $data = [
            'body' => json_encode(
                [
                    'jsonrpc' => '2.0',
                    'method'  => 'login',
                    'params'  => [
                        'email'    => $email,
                        'password' => $password,
                    ],
                ]
            ),
        ];

        $response = $client->post($this->baseUrl . '/authentication/login', $data);
        $json     = $response->getBody()->getContents();
        $body     = json_decode($json, true);

        return array_key_exists('result', $body) ? $body['result']['token'] : null;
    }

    /**
     * @param string $operation
     * @param array  $parameters
     *
     * @return array
     */
    protected function createData(string $operation, array $parameters)
    {
        return [
            'body' => json_encode(
                [
                    'jsonrpc' => '2.0',
                    'method'  => $operation,
                    'params'  => $parameters,
                ]
            ),
        ];
    }

    public function testGetUser()
    {
        $token = $this->authorize();

        $client = new Client([
            'base_uri' => $this->baseUrl,
            'headers'  => [
                'Authorization' => 'Basic ' . $token,
                'Content-Type'  => 'application/json',
            ],
        ]);

        $data     = $this->createData('getUserById', ['id' => 1]);
        $response = $client->post('/authentication/user', $data);
        $json     = json_decode($response->getBody()->getContents(), true);
        $body     = array_key_exists('result', $json) ? $json['result'] : null;

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, $body['id']);
    }
}
