<?php
//declare(strict_types = 1);
//
//namespace Tests\PropertyBundle\Controller;
//
//use GuzzleHttp\Client;
//use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
//
///**
// * PropertyController Test
// */
//class PropertyControllerTest extends WebTestCase
//{
//    /**
//     * @var string
//     */
//    protected $baseUrl = 'https://engine.propertywindow.nl';
//
//    /**
//     * @param string $email
//     * @param string $password
//     *
//     * @return string|null
//     */
//    public function authorize($email = 'michael@annan.co.uk', $password = 'michael')
//    {
//        $client = new Client([
//            'base_uri' => $this->baseUrl,
//            'headers'  => [
//                'Content-Type' => 'application/json',
//            ],
//        ]);
//
//        $data = [
//            'body' => json_encode(
//                [
//                    'jsonrpc' => '2.0',
//                    'method'  => 'login',
//                    'params'  => [
//                        'email'    => $email,
//                        'password' => $password,
//                    ],
//                ]
//            ),
//        ];
//
//        $response = $client->post($this->baseUrl . '/authentication/login', $data);
//        $json     = $response->getBody()->getContents();
//        $body     = json_decode($json, true);
//
//        return array_key_exists('result', $body) ? $body['result']['token'] : null;
//    }
//
//    /**
//     * @param string $operation
//     * @param array  $parameters
//     *
//     * @return array
//     */
//    protected function createData(string $operation, array $parameters)
//    {
//        return [
//            'body' => json_encode(
//                [
//                    'jsonrpc' => '2.0',
//                    'method'  => $operation,
//                    'params'  => $parameters,
//                ]
//            ),
//        ];
//    }
//
//    public function testGetProperty()
//    {
//        $token = $this->authorize();
//
//        $client = new Client([
//            'base_uri' => $this->baseUrl,
//            'headers'  => [
//                'Authorization' => 'Basic ' . $token,
//                'Content-Type'  => 'application/json',
//            ],
//        ]);
//
//        $data     = $this->createData('getProperty', ['id' => 1]);
//        $response = $client->post('/property', $data);
//        $json     = json_decode($response->getBody()->getContents(), true);
//        $body     = array_key_exists('result', $json) ? $json['result'] : null;
//
//        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals(1, $body['id']);
//    }
//}
