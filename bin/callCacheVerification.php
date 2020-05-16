<?php

require_once __DIR__ . '/../vendor/autoload.php';

set_time_limit(300);

echo 'start';

(new Kiryi\MonztaRecord\Helper\CacheHandler)->verifyCacheLife();

echo 'end';
