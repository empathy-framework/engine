<?php

namespace Empathy\Engine\Components;

use VoidCore;
use Empathy\Engine\Control;

class Form extends Control
{
    protected ?string $classname = 'System.Windows.Forms.Form';
	protected ?string $assembly  = 'System.Windows.Forms';

    public function get_clientSize ()
	{
		$size = $this->getProperty ('ClientSize');
		
		return [
			VoidCore::getProperty ($size, 'Width'),
			VoidCore::getProperty ($size, 'Height')
		];
	}

	public function set_clientSize ($size)
	{
		if (is_array ($size))
		{
			$clientSize = $this->getProperty ('ClientSize');

			VoidCore::setProperty ($clientSize, 'Width', array_shift ($size));
			VoidCore::setProperty ($clientSize, 'Height', array_shift ($size));

			$this->setProperty ('ClientSize', $clientSize);
		}

		else $this->setProperty ('ClientSize', EngineAdditions::uncoupleSelector ($size));
	}

	public function loadIcon (string $file)
	{
		$icon = VoidCore::createObject ('System.Drawing.Icon', 'System.Drawing', $file);

		$this->setProperty ('Icon', $icon);
	}
}
