<?php

namespace App\APITransferWise;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

class API
{
    const BASE_URL_API_PRODUCTION = 'https://api.transferwise.tech/v1/';

    const BASE_URL_API_SANDBOX = 'https://api.sandbox.transferwise.tech/v1/';

    const METHOD_GET = 'GET';

    const METHOD_POST = 'POST';

    const METHOD_PUT = 'PUT';

    const METHOD_DELETE = 'DELETE';

    protected $apiToken = '';

    protected $request;

    public function __construct($token, $options = [])
    {
        $this->apiToken = $token;

        $this->request = $this->buildRequest($options);
    }

    protected function getBaseUri($opts)
    {
        return isset($opts['sandbox']) && $opts['sandbox'] ? self::BASE_URL_API_SANDBOX : self::BASE_URL_API_PRODUCTION;
    }

    protected function buildRequest($options)
    {
        $clientOpts = [
            'base_uri' => $this->getBaseUri($options),

            RequestOptions::TIMEOUT => 30,

            RequestOptions::HEADERS => [
                'Authorization' => 'Bearer ' . $this->apiToken,
                'Content-Type' => 'application/json',
            ],
        ];

        return new Client($clientOpts);
    }

    protected function decode(ResponseInterface $request)
    {
        return json_decode(
            $request->getBody(),
            true
        );
    }

    public function getProfile()
    {
        return $this->decode($this->request->request(self::METHOD_GET, 'profiles'));
    }

    public function createRecipientAccount($body)
    {
        return $this->decode($this->request->request(self::METHOD_POST, 'accounts', [
            'body' => json_encode($body)
        ]));
    }
}