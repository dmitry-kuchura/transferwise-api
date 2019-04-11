<?php
/**
 * Created by PhpStorm.
 * User: Hertz
 * Date: 19.11.2018
 * Time: 02:13
 */

namespace TWAPI\Transport;


use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\UriTemplate;

abstract class TransportFactory
{
    public static function createGuzzleTransport($opts): GuzzleTransport
    {

        $clientOpts = [
            'base_uri' => $opts['base_url'],

            RequestOptions::TIMEOUT =>
                $opts['timeout'] ?? 30,

            RequestOptions::HEADERS => [
                'Authorization' => 'Bearer ' . $opts['token']
            ],
        ];

        $client = new Client($clientOpts);
        return new GuzzleTransport($client, new UriTemplate());
    }
}