<?php

namespace AnyMarket\Sdk;

use GuzzleHttp\Client;

class Request
{
    /**
     * HTTP OPTIONS
     *
     * @var array
     */
    protected static $OPTIONS = [
        'Accept'       => 'application/json',
        'Content-Type' => 'application/json',
        'uSER-aGENT'   => 'ANYMARKET-PHP-SDK-1.0.0',
        'debug'        => false,
    ];

    /**
     * @var $handler
     */
    protected $handler;

    /**
     * Constructor
     *
     * Create new request instance
     *
     * @param $handler
     */
    public function __construct($handler)
    {
        $this->handler = $handler;
    }

    /**
     *  Execute the request
     *
     * @param string $method
     * @param string $url
     * @param array $data
     *
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function execute($method, $uri, array $data = [])
    {
        $client = new Client(['handler' => $this->handler]);

        return json_decode($client->request($method, $uri, array_merge($data, self::$OPTIONS))->getBody());
    }
}
