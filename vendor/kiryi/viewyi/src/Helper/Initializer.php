<?php

namespace Kiryi\Viewyi\Helper;

use Kiryi\Pathyi\Formatter as Pathyi;
use Kiryi\Inyi\Reader as Inyi;

class Initializer extends \Exception
{
    const ERRORMSG_ARGUMENTMISSING = 'VIEWYI INITIALIZATION ERROR: Argument "%s" is missing!';
    const ERRORMSG_INIFILEKEYMISSING = 'VIEWYI INITIALIZATION ERROR: Key "%s" is missing in INI file!';
    const CONFIGPARAMS_ALL = ['baseUrl', 'imagePath', 'templateDirectory', 'templateFileExtension'];
    const CONFIGPARAMS_OPTIONAL = ['templateFileExtension'];
    const CONFIGFILE_SECTION = 'viewyi';
    
    private string $configFilepath = 'config/viewyi.ini';
    private ?Pathyi $pathy = null;
    
    private array $config = [];

    public function __construct($config)
    {
        $this->pathyi = new Pathyi();

        if (is_array($config) === true) {
            $this->initConfigWithArguments($config);
        } elseif (is_string($config) === true) {
            $this->initConfigWithFile(new Inyi($this->pathyi->format($config)));
        } elseif ($config === null) {
            $this->initConfigWithFile(new Inyi($this->configFilepath));
        }
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    private function initConfigWithArguments(array $args): void
    {
        foreach ($this::CONFIGPARAMS_ALL as $key) {
            if (isset($args[$key]) === true) {
                $this->config[$key] = $args[$key];
            } elseif (
                isset($args[$key]) === false
                && in_array($key, $this::CONFIGPARAMS_OPTIONAL) !== true
            ) {
                throw new \Exception(sprintf($this::ERRORMSG_ARGUMENTMISSING, $key));
            }
        }
    }

    private function initConfigWithFile(Inyi $inyi): void
    {
        foreach ($this::CONFIGPARAMS_ALL as $key) {
            try {
                $this->config[$key] = $inyi->get($this::CONFIGFILE_SECTION . '::' . $key);
            } catch (\Exception $e) {
                if (in_array($key, $this::CONFIGPARAMS_OPTIONAL) !== true) {
                    throw new \Exception(sprintf($this::ERRORMSG_INIFILEKEYMISSING, $key));
                }
            }
            
        }
    }
}
