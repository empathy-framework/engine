<?php

namespace Empathy\Engine\Components;

use Empathy\Engine\Control;

class ListBox extends Control
{
    protected ?string $classname = 'System.Windows.Forms.ListBox';
	protected ?string $assembly  = 'System.Windows.Forms';
}

class CheckedListBox extends Control
{
    protected ?string $classname = 'System.Windows.Forms.CheckedListBox';
	protected ?string $assembly  = 'System.Windows.Forms';
}
