<?php

namespace Kiryi\Routyi;

use Kiryi\Routyi\Helper;
use Kiryi\Pathyi\Formatter as Pathyi;

class Router
{
    const ROOTDIR = __DIR__ . '/../../../../';

    private ?string $namespace = null;
    private string $routingTableFilepath = 'config/routing.ini';
    private string $configFilepath = 'config/routyi.ini';

    private ?Helper\EndpointSearcher $searcher = null;
    private ?Pathyi $pathyi = null;

    public function __construct(
        ?string $namespace = null,
        ?string $routingTableFilepath = null,
        ?string $configFilepath = null
    ) {
        $this->pathyi = new Pathyi();
        
        $this->namespace = $namespace;
        $this->setFilepaths($routingTableFilepath, $configFilepath);

        $this->searcher = new Helper\EndpointSearcher($this->routingTableFilepath);
    }

    public function route(): void
    {
        $uriPath = (new Helper\UriPathGetter($this->configFilepath))->get();

        $route = $this->extractRoute($uriPath);
        $params = $this->extractParams($uriPath, $route);
        
        $endpoint = $this->getEndpoint($route);
        (new $endpoint())->run($params);
    }
    
    private function extractRoute(string $uriPath): string
    {
        while (strrpos($uriPath, '/') !== false) {
            if (null !== $this->searcher->find($uriPath)) {
                return $uriPath;
            } else {
                if (0 !== $separatorPosition = strrpos($uriPath, '/')) {
                    $uriPath = substr($uriPath, 0, $separatorPosition);
                } else {
                    $uriPath = '/';
                }
            }
        }
    }
    
    private function extractParams(string $uriPath, string $route): array
    {
        if ($uriPath == $route) {
            return [];
        } else {
            return explode('/', $this->pathyi->format(substr($uriPath, strlen($route))));
        }
    }

    private function getEndpoint(string $route): string
    {
        if ($this->namespace !== null) {
            $namespace = $this->pathyi->format($this->namespace, true, true);

            return $namespace . $this->pathyi->format($this->searcher->find($route));
        } else {
            return $this->pathyi->format($this->searcher->find($route), true);
        }
    }

    private function setFilepaths(?string $routingTableFilepath, ?string $configFilepath): void
    {
        if ($routingTableFilepath !== null) {
            $this->routingTableFilepath = $this->pathyi->format($routingTableFilepath);
        }

        if ($configFilepath !== null) {
            $this->configFilepath = $this->pathyi->format($configFilepath);
        }
    }
}
