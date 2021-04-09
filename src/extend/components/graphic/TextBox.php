<?php

namespace Empathy\Engine\Components;

use Empathy\Engine\Control;

class TextBox extends Control
{
    protected ?string $classname = 'System.Windows.Forms.TextBox';
	protected ?string $assembly  = 'System.Windows.Forms';
}

class MaskedTextBox extends Control
{
    protected ?string $classname = 'System.Windows.Forms.MaskedTextBox';
	protected ?string $assembly  = 'System.Windows.Forms';
}

class RichTextBox extends Control
{
    protected ?string $classname = 'System.Windows.Forms.RichTextBox';
	protected ?string $assembly  = 'System.Windows.Forms';
}
