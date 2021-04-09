<?php

namespace Empathy\Engine\Components;

use Empathy\Engine\Control;

class WebBrowser extends Control
{
    protected ?string $classname = 'System.Windows.Forms.WebBrowser';
    protected ?string $assembly  = 'System.Windows.Forms';

    public function browse (string $url): void
    {
        $this->callMethod ('Navigate', $url);
    }
}
