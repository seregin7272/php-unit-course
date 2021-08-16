<?php

namespace Test;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class ApiClientTest extends \PHPUnit\Framework\TestCase
{
    protected $apiClient;

    /**
     * @var \GuzzleHttp\Handler\MockHandler
     */
    private MockHandler $mockHandler;

    protected function setUp(): void
    {
        //$httpClient = new Client(['base_uri' => 'http://api.postcodes.io']);
        $this->mockHandler = new MockHandler();
        $httpClient = new Client(['handler' => $this->mockHandler]);
        $this->apiClient = new \Api\ApiClient($httpClient);
    }

    public function testShowPostcodeData(): void
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__ . '/fixtures/postcode.json')));

        $response = $this->apiClient->getPostcodeData('OX49 5NU');
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('admin_district', $data['result']);
    }

    public function testShowPostcodesData(): void
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__ . '/fixtures/postcodes.json')));
        $response = $this->apiClient->getPostcodesData(["OX49 5NU", "M32 0JG", "NE30 1DP"]);

        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true);
        $this->assertCount(3, $data['result']);
    }
}