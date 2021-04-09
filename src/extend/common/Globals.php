<?php

namespace Empathy\Engine\Globals;

use VoidCore;
use Empathy\Engine\Wrappers\NetClass;
use Empathy\Engine\Additions;

register_superglobals ('APPLICATION', 'SCREEN');

/**
 * Переменная-класс приложения
 */
$APPLICATION = new NetClass ('System.Windows.Forms.Application');

/**
 * Переменная-класс экрана
 */
$SCREEN = new class
{
    public NetClass $screen;
    
    public function __construct ()
    {
        $this->screen = new NetClass ('System.Windows.Forms.Screen');
    }
    
    public function __get ($name)
    {
        switch (strtolower ($name))
        {
            case 'width':
            case 'w':
                return $this->screen->primaryScreen->bounds->width;
            break;
            
            case 'height':
            case 'h':
                return $this->screen->primaryScreen->bounds->height;
            break;

            default:
                return Additions::coupleSelector ($this->screen->$name);
            break;
        }
    }
    
    public function __debugInfo (): array
    {
        return [
            $this->w,
            $this->h
        ];
    }
};
