<?php

namespace Kiryi\Viewyi;

use Kiryi\Viewyi\Helper;

class Engine extends \Exception
{
    const ERRORMSG_RENDERNOTCALLED = 'VIEWYI SEQUENCE ERROR: Function "render" was not called before function "display"!';
    const ERRORMSG_DISPLAYCALLEDTWICE = 'VIEWYI SEQUENCE ERROR: Function "display" was called twice!';
    const TEMPLATENAME_INTERNAL_BASE = 'base';

    private ?Helper\Builder $builder = null;

    private bool $renderWasCalled = false;
    private bool $displayWasCalled = false;

    private array $data = [];
    private string $view = '';

    public function __construct($config = null)
    {
        $initializer = new Helper\Initializer($config);
        $this->builder = new Helper\Builder($initializer->getConfig());
    }

    public function assign(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    public function render(string $template): string
    {
        $this->view .= $this->build($template);

        $this->renderWasCalled = true;

        return $this->view;
    }

    public function reset(): string
    {
        $currentView = $this->view;

        $this->view = '';
        $this->data = [];

        return $currentView;
    }

    public function display(string $headTemplate, string $title): void
    {
        if ($this->renderWasCalled !== true) {
            throw new \Exception($this::ERRORMSG_RENDERNOTCALLED);
        } elseif ($this->displayWasCalled === true) {
            throw new \Exception($this::ERRORMSG_DISPLAYCALLEDTWICE);
        } else {
            
            $data = [
                'title' => $title,
                'head' => $this->build($headTemplate),
                'body' => $this->view,
            ];
    
            $display = $this->builder->build($this::TEMPLATENAME_INTERNAL_BASE, $data, false);
            
            $this->displayWasCalled = true;
    
            echo $display;
        }
    }

    private function build(string $template): string
    {
        return $this->builder->build($template, $this->data);
    }
}
