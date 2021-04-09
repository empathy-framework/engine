<?php

namespace Empathy\Engine;

use VoidCore;
use Empathy\Engine\Additions;
use Empathy\Engine\Wrappers\NetObject;

/**
 * Менеджер событий объектов
 */
class Events
{
    /**
     * Установить событие объекту
     * 
     * @param int $selector - указатель на объект
     * @param string $eventName - название события
     * @param callable $callback - коллбэк
     */
    public static function setEvent (int $selector, string $eventName, callable $callback): void
    {
        VoidCore::setEvent ($selector, $eventName, function ($sender, ...$args) use ($callback)
		{
            foreach ($args as $id => $arg)
                $args[$id] = Additions::coupleSelector ($arg);

            try
			{
                return $callback (_c($sender) ?: new NetObject ($sender), ...$args);
            }
            
			catch (\Throwable $e)
			{
                message ([
                    'type'  => get_class ($e),
                    'text'  => $e->getMessage (),
                    'file'  => $e->getFile (),
                    'line'  => $e->getLine (),
                    'code'  => $e->getCode (),
                    'trace' => $e->getTraceAsString ()
                ], 'PHP Critical Error');
            }
        });
    }

    /**
     * Удаление события объекта
     * 
     * @param int $selector - указатель на объект
     * @param string $eventName - название события
     */
    public static function removeEvent (int $selector, string $eventName): void
    {
        VoidCore::removeEvent ($selector, $eventName);
    }
}
