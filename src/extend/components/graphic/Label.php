<?php

namespace Empathy\Engine\Components;

use Empathy\Engine\Control;

class Label extends Control
{
    protected ?string $classname = 'System.Windows.Forms.Label';
	protected ?string $assembly  = 'System.Windows.Forms';
}

class LinkLabel extends Control
{
    protected ?string $classname = 'System.Windows.Forms.LinkLabel';
	protected ?string $assembly  = 'System.Windows.Forms';
}
