<?php

namespace Empathy\Engine\Async;

/**
 * Объект реализации асинхронной задачи
 */
class Task
{
    protected $callable;
    protected $pause;

    protected bool $executed  = false;
    protected bool $completed = false;
    protected $result = null;

    /**
     * Конструктор задачи
     * 
     * @param callable $callable - выполняемый PHP коллбэк function ($this)
     */
    public function __construct (callable $callable)
    {
        $this->callable = $callable;

        $this->executed = false;
        $this->completed = false;
    }

    public static function create (callable $callable): Task
    {
        return new Task ($callable);
    }

    /**
     * Событие для выполнения при вызове метода ->sleep текущей задачи
     */
    public function onSleep (callable $callable): Task
    {
        $this->pause = $callable;

        return $this;
    }

    /**
     * Начать выполнение задачи
     */
    public function run (): Task
    {
        $this->executed = true;

        $thread = thread (function ()
        {
            $this->completed = false;
            $this->result    = ($this->callable)($this);
            $this->completed = true;
        });

        $thread->isBackground = true;
        $thread->start ();

        return $this;
    }

    public function sleep (int $time): Task
    {
        if (is_callable ($this->pause))
            ($this->pause)();

        timeout ($time);

        return $this;
    }

    public function completed (): bool
    {
        return $this->completed;
    }

    public function executed (): bool
    {
        return $this->executed;
    }

    public function result ()
    {
        return $this->result;
    }

    public function wait (int $time = null): Task
    {
        if ($time !== null)
            timeout ($time);

        else while (!$this->completed);

        return $this;
    }
}
