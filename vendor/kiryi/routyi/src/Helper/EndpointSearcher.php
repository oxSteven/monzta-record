<?php

namespace Kiryi\Routyi\Helper;

use Kiryi\Inyi\Reader as Inyi;

class EndpointSearcher extends \Exception
{
    private ?Inyi $inyi = null;

    public function __construct(string $routingTableFilepath)
    {
        $this->inyi = new Inyi($routingTableFilepath);
    }
    
    public function find(string $route): ?string
    {
        try {
            return $this->inyi->get($route);
        } catch (\Exception $e) {
            return null;
        }
    }
}
