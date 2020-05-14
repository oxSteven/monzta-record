<?php

namespace Kiryi\Flaryi\Endpoint;

use Kiryi\Flaryi\Client;

abstract class Endpoint extends \Exception
{
    CONST NOTFOUND = 'FLARYI ERROR: No %s found with %s "%s"!';
    const JSONFILEPATH = __DIR__ . '/../../asset/json/';
    const APIENDPOINT = '';

    protected ?Client $client = null;
    protected string $type = '';
    protected string $uri = '';
    protected string $body = '';

    public function __construct (Client $client)
    {
        $this->client = $client;
    }

    protected function call(): object
    {
        return json_decode($this->client->sendRequest($this->type, $this->uri, $this->body));
    }

    protected function setType(string $type): void
    {
        $this->type = $type;
    }

    protected function setUri(string $uri = ''): void
    {
        if ($this->uri == '') {
            $this->uri = $this::APIENDPOINT . $uri;
        } else {
            $this->uri = $this->uri . $uri;
        }
        
    }

    protected function setBody(string $body = ''): void
    {
        $this->body = $body;
    }

    protected function getJsonBody(): string
    {
        $className = lcfirst((new \ReflectionClass($this))->getShortName());
        $functionName = ucfirst(debug_backtrace()[1]['function']);

        return file_get_contents(self::JSONFILEPATH . $className . $functionName . '.json');
    }

    protected function createDataObjectJson(string $type, string $id): string
    {
        return sprintf(file_get_contents(self::JSONFILEPATH . 'data.json'), $type, $id);
    }

    protected function setEndpointId(int $id): string
    {
        $uriPart = '';

        if ($id !== null) {
            $uriPart .= '/' . $id;
        }

        return $uriPart;
    }

    protected function setResponseFields(?array $responseFields): string
    {
        $uriPart = '';

        if ($responseFields !== null) {
            if (strpos($this->uri, '?') === false)
            {
                $uriPart .= '?';
            } else {
                $uriPart .= '&';
            }

            $uriPart .= 'fields[' . $this::APIENDPOINT . ']=';

            foreach ($responseFields as $field) {
                $uriPart .= $field . ',';
            }
            
            $uriPart = substr($uriPart, 0, -1);
        }

        return $uriPart;
    }

    protected function setFilter(?string $filter): string
    {
        $uriPart = '';

        if ($filter !== null) {
            if (strpos($this->uri, '?') === false)
            {
                $uriPart .= '?';
            } else {
                $uriPart .= '&';
            }

            $uriPart .= 'filter[q]=' . $filter;
        }

        return $uriPart;
    }

    protected function setPagination(?int $pageOffset): string
    {
        $uriPart = '';

        if ($pageOffset !== null) {
            if (strpos($this->uri, '?') === false)
            {
                $uriPart .= '?';
            } else {
                $uriPart .= '&';
            }

            $uriPart .= 'page[offset]=' . $pageOffset;
        }

        return $uriPart;
    }
}
