<?php

require_once __DIR__ . '/../vendor/autoload.php';

set_time_limit(35);

(new Kiryi\MonztaRecord\Helper\CacheHandler)->verifyCacheLife();