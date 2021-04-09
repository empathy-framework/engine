<?php

namespace Empathy\Engine\Components;

use Empathy\Engine\Control;

/**
 * Компонент, представляющий список изображений
 * Может быть использован в ListView
 */
class ImageList extends Control
{
    protected ?string $classname = 'System.Windows.Forms.ImageList';
	protected ?string $assembly  = 'System.Windows.Forms';
}
