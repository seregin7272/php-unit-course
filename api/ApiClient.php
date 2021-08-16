<?php
declare(strict_types=1);

namespace Api;


use GuzzleHttp\Client;

class ApiClient
{
    private Client $httpClient;
    
    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getPostcodeData($postcode)
    {
       return $this->httpClient->get('/postcodes/' . $postcode);
    }

    public function getPostcodesData(array $postcodes)
    {
        $postcodes = [
            'json' => [
                'postcodes' => $postcodes
            ]
        ];
        return $this->httpClient->post('/postcodes', $postcodes);
    }
}