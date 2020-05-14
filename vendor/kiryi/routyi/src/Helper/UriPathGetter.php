<?php

namespace Kiryi\Routyi\Helper;

use Kiryi\Inyi\Reader as Inyi;
use Kiryi\Pathyi\Formatter as Pathyi;

class UriPathGetter extends \Exception
{
    const INIKEY_SUBDIR = 'routyi::subDir';

    private string $configFilepath = '';

    public function __construct(string $configFilepath)
    {
        $this->configFilepath = $configFilepath;
    }

    public function get(): string
    {
        $pathyi = new Pathyi();

        $requestUri = $pathyi->format($_SERVER['REQUEST_URI'], true);

        try {
            $subDir = $pathyi->format((new Inyi($this->configFilepath))->get($this::INIKEY_SUBDIR), true);
            $requestUri = str_replace($subDir, '', $requestUri);
        } catch (\Exception $e) {
            // nothing to do
        } finally {
            return $this->verifyUriPath($requestUri);
        }
    }

    private function verifyUriPath(string $uriPath): string
    {
        if ($uriPath == '') {
            return '/';
        } else {
            return $uriPath;
        }
    }
}
