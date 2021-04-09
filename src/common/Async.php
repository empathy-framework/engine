<?php

namespace Empathy\Engine\Async;

use VoidCore;
use Empathy\Engine\Wrappers\NetObject;

require 'async/Task.php';
require 'async/EventLoop.php';

/**
 * Функция упрощения создания экземпляра потока
 * 
 * @param callable $callable - коллбэк потока
 * 
 * @return NetObject
 */
function thread (callable $callable): NetObject
{
    return new NetObject (VoidCore::createThread ($callable));
}
