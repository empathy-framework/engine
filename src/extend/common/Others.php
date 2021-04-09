<?php

namespace Empathy\Engine\Others;

use Empathy\Engine\Components\{
    Timer,
    Process,
    MessageBox
};

/**
 * Вывод MessageBox
 * 
 * @param string $message - сообщение
 * [@param string $caption = ''] - заголовок
 * @param ...$args - дополнительные аргументы
 * 
 * @return int - возвращает ответ диалога
 */
function messageBox (string $message, string $caption = '', ...$args): int
{
    return (new MessageBox)->show ($message, $caption, ...$args);
}

/**
 * Запуск приложения
 * 
 * @param string $path - путь к приложению
 * @param ...$args - аргументы запуска
 */
function run (string $path, ...$args)
{
    return (new Process)->start ($path, ...$args);
}

/**
 * Выполнение коллбэка каждые $timeout миллисекунд
 * 
 * @param int $interval - период выполнения (в миллисекундах)
 * @param callable $callback - коллбэк для выполнения
 * 
 * @return Timer - возвращает таймер
 */
function setTimer (int $interval, callable $callback): Timer
{
    $timer = new Timer;
    $timer->interval  = $interval;
    $timer->tickEvent = fn ($self) => $callback ($self);
    
	$timer->start ();
    
    return $timer;
}

/**
 * Выполнение коллбэка через $timeout миллисекунд
 * 
 * @param int $timeout - таймаут (в миллисекундах)
 * @param callable $callback - коллбэк для выполнения
 * 
 * @return Timer - возвращает таймер
 */
function setTimeout (int $timeout, callable $callback): Timer
{
    $timer = new Timer;
    $timer->interval  = $timeout;
    $timer->tickEvent = function ($self) use ($callback)
    {
        $self->stop ();

        $callback ($self);
    };
    
	$timer->start ();
    
	return $timer;
}
