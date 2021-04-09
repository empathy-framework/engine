<?php

namespace Empathy\Engine\Components;

use Empathy\Engine\Control;

/**
 * Компонент "Таймер"
 */
class Timer extends Control
{
    protected ?string $classname = 'System.Windows.Forms.Timer';
	protected ?string $assembly  = 'System.Windows.Forms';
}
