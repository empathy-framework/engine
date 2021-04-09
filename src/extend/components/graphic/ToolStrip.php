<?php

namespace Empathy\Engine\Components;

use Empathy\Engine\Control;

class ToolStrip extends Control
{
    protected ?string $classname = 'System.Windows.Forms.ToolStrip';
	protected ?string $assembly  = 'System.Windows.Forms';
}

class ToolStripStatusLabel extends Control
{
    protected ?string $classname = 'System.Windows.Forms.ToolStripStatusLabel';
	protected ?string $assembly  = 'System.Windows.Forms';
}
