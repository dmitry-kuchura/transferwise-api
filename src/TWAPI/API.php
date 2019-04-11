<?php
declare(strict_types=1);

namespace TWAPI;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\UriTemplate;
use TWAPI\Transport\GuzzleTransport;
use TWAPI\Transport\Transport;
use TWAPI\Transport\TransportFactory;

class API
{
    protected const BASE_URL_API_PRODUCTION = 'https://api.transferwise.tech/v1/';
    protected const BASE_URL_API_SANDBOX = 'https://api.sandbox.transferwise.tech/v1/';

    protected $profiles;

    protected $apiToken;
    /**
     * @var Transport
     */
    protected $transport;

    /**
     * API constructor.
     * @param $token Access Token
     * @param array $options Advanced options for transport
     */
    public function __construct($token, array $options = [])
    {
        $this->transport = $this->buildTransport($token, $options);
    }

    protected function getBaseUri($opts): string
    {
        return isset($opts['sandbox']) && $opts['sandbox']
            ? self::BASE_URL_API_SANDBOX
            : self::BASE_URL_API_PRODUCTION;
    }

    protected function buildTransport($token, $options): Transport
    {
        $baseUrl = $this->getBaseUri($options);

        $opts = array_merge([], $options);
        $opts['base_url'] = $baseUrl;
        $opts['token'] = $baseUrl;

        return TransportFactory::createGuzzleTransport($opts);
    }


    public function profiles()
    {
        if (!$this->profiles) {
            $this->profiles = new ProfilesAPI($this->transport);
        }
        return $this->profiles;
    }


}