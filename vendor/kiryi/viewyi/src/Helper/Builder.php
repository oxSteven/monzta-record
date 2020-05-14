<?php

namespace Kiryi\Viewyi\Helper;

use Kiryi\Pathyi\Formatter as Pathyi;

class Builder extends \Exception
{
    const ERRORMSG_TEMPLATENOTFOUND = 'VIEWYI TEMPLATE ERROR: Template "%s" not found!';
    const ROOTDIR = __DIR__ . '/../../../../../';
    const TEMPLATEFILEPATH_INTERNAL = __DIR__ . '/../View/';
    const TEMPLATEFILEEXTENSION_INTERNAL = '.tpl.php';

    private ?Pathyi $pathy = null;

    private string $baseUrl = '';
    private string $imgPath = '';
    private string $tplDir = '';
    private string $tplFileExtensionCustom = '.php';

    public function __construct(array $config)
    {
        $this->pathyi = new Pathyi();

        $this->baseUrl = $this->pathyi->format($config['baseUrl'], false, true);
        $this->imgPath = $this->baseUrl . $this->pathyi->format($config['imagePath'], false, true);
        $this->tplDir = $this::ROOTDIR . $this->pathyi->format($config['templateDirectory'], false, true);

        if (isset($config['templateFileExtension']) === true) {
            $this->tplFileExtensionCustom = $config['templateFileExtension'];
        }
    }

    public function build(string $template, array $data, bool $customTpl = true): string
    {
        if ($customTpl !== true) {
            $template = $this->getInternalTemplateFilepath($template);
        } else {
            $template = $this->getCustomTemplateFilepath($template);
        }

        $a = $this->baseUrl;
        $i = $this->imgPath;
        $d = $this->createViewData($data);

        ob_start();
        
        require $template;

        return ob_get_clean();
    }

    private function getCustomTemplateFilepath($template): string
    {
        $template = $this->tplDir . $this->pathyi->format($template) . $this->tplFileExtensionCustom;

        if (file_exists($template) !== false) {
            return $template;
        } else {
            throw new \Exception(sprintf($this::ERRORMSG_TEMPLATENOTFOUND, $template));
        }
    }

    private function getInternalTemplateFilepath(string $template): string
    {
        return $this::TEMPLATEFILEPATH_INTERNAL . $this->pathyi->format($template) . $this::TEMPLATEFILEEXTENSION_INTERNAL;
    }

    private function createViewData(array $data): object
    {
        return json_decode(json_encode($data));
    }
}
