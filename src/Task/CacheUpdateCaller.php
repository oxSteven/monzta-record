<?php

namespace Kiryi\MonztaRecord\Task;

use Kiryi\Routyi\EndpointInterface;
use Kiryi\MonztaRecord\Helper\CacheHandler;

class CacheUpdateCaller implements EndpointInterface
{
    const ACCESSKEY = 'nsSs83BK8kbAvjjreYEP438KALKUgxr3';
    const ERRORMESSAGE = 'Forbidden Access!';
    const EXECUTIONTIMELIMIT = 300;

    public function run(array $params): void
    {
        if (
            isset($params[0]) === true
            && $params[0] == $this::ACCESSKEY
        ) {
            $this->callUpdater();
        } else {
            echo $this::ERRORMESSAGE;
        }
    }

    private function callUpdater(): void
    {
        set_time_limit($this::EXECUTIONTIMELIMIT);
        (new CacheHandler)->verifyCacheLife();
    }
}
