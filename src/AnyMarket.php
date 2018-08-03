<?php

namespace AnyMarket\Sdk;

use AnyMarket\Sdk\RequestMethods as Method;

class AnyMarket
{
    /**
     * @version 1.1.0
     */
    const VERSION = "1.1.0";

    /**
     * AnyMarket API
     *
     * @var string
     */
    protected static $ANYMARKET_URL_API = "http://api.anymarket.com.br/v2";

    /**
     * AnyMarket sandbox
     *
     * @var string
     */
    protected static $ANYMARKET_URL_SANDBOX = "http://sandbox-api.anymarket.com.br/v2";

    /**
     * AnyMarket access token
     *
     * @var string
     */
    protected $token;

    /**
     * AnyMarket sandbox
     *
     * @var string
     */
    protected $sandbox;

    /**
     * AnyMarket handler
     *
     * @var string
     */
    protected $handler;

    /**
     * Anymarket constructor
     *
     * @param $token
     * @param bool $sandbox
     */
    public function __construct($token, $sandbox = false)
    {
        $this->token = $token;
        $this->sandbox = $sandbox;
    }

    /**
     * Execute GET request
     *
     * @param $resource
     * @param array $query
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($resource, array $query = [])
    {
        $exec = $this->execute(Method::$HTTP_GET, $resource, ['query' => $query]);

        return $exec;
    }

    /**
     * Execute POST request
     *
     * @param $resource
     * @param array $data
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post($resource, $data = [])
    {
        $exec = $this->execute(Method::$HTTP_POST, $resource, ['json' => $data]);

        return $exec;
    }

    /**
     * Execute PUT request
     *
     * @param $resource
     * @param array $data
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function put($resource, $data = [])
    {
        $exec = $this->execute(Method::$HTTP_PUT, $resource, ['json' => $data]);

        return $exec;
    }

    /**
     * Execute DELETE request
     *
     * @param $resource
     * @param array $data
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete($resource)
    {
        $exec = $this->execute(Method::$HTTP_DELETE, $resource);

        return $exec;
    }

    /**
     * Check and construct an real URL to make request
     *
     * @param $resource
     * @param array $query
     * @return string
     */
    public function makeUrl($resource)
    {
        $uri = ($this->sandbox != false) ? self::$ANYMARKET_URL_SANDBOX : self::$ANYMARKET_URL_API;
        if (! preg_match("/^http/", $resource)) {
            if (! preg_match("/^\//", $resource)) {
                $resource = '/' . $resource;
            }
        }
        $uri .= $resource;

        return $uri;
    }

    /**
     * Execute the resource
     *
     * @param $method
     * @param $resource
     * @param array $data
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function execute($method, $resource, array $data = [])
    {
        $request = new Request($this->handler);
        $dataResource = $request->execute($method, $this->makeUrl($resource), array_merge($data, [
            'headers' => [
                'gumgaToken' => $this->token
            ]
        ]));

        return $dataResource;
    }
}
