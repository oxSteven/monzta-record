<?php

namespace Kiryi\Flaryi;

use Kiryi\Pathyi\Formatter as Pathyi;
use Kiryi\Inyi\Reader as Inyi;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request as GuzzleRequest;

class Client
{
    const CONFIGFILE_STANDARDPATH = 'config/flaryi.ini';
    const CONFIGFILE_PARAM_URL = 'flaryi::apiUrl';
    const CONFIGFILE_PARAM_KEY = 'flaryi::apiKey';
    const ENDPOINT_FULLYQUALIFIEDNAMESPACE = 'Kiryi\\Flaryi\\Endpoint\\';

    private ?Inyi $inyi = null;
    private ?GuzzleClient $client = null;
    private array $headers = [];

    public function __construct(string $filepath = null)
    {
        if ($filepath === null) {
            $filepath = $this::CONFIGFILE_STANDARDPATH;
        }
        
        $this->inyi = new Inyi($filepath);
        $this->initClient();
        $this->setHeaders();
    }

    public function call(string $endpoint): object
    {
        $endpoint = $this::ENDPOINT_FULLYQUALIFIEDNAMESPACE . $endpoint;

        return new $endpoint($this);
    }

    public function sendRequest(string $type, string $uri, string $body): string
    {
        $request = new GuzzleRequest($type, $uri, $this->headers, $body);

        return $this->client->send($request)->getBody()->getContents();
    }

    private function initClient()
    {
        $apiUrl = (new Pathyi())->format($this->inyi->get($this::CONFIGFILE_PARAM_URL), false, true);

        $this->client = new GuzzleClient([
            'base_uri' => $apiUrl,
        ]);
    }

    private function setHeaders()
    {
        $apiKey = $this->inyi->get($this::CONFIGFILE_PARAM_KEY);

        $this->headers = [
            'Authorization' => 'Token ' . $apiKey,
            "content-type" => 'application/json',
        ];
    }
}
