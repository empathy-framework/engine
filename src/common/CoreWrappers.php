<?php

namespace Empathy\Engine\Wrappers;

use VoidCore;

use Empathy\Engine\{
    Additions,
    Events
};

/**
 * Контроллер .NET объекта
 */
class NetObject implements \ArrayAccess
{
    protected int $selector; // Указатель на объект

    /**
     * Конструктор контроллера
     * 
     * @param mixed $name - указатель на .NET объект или его имя
     * [@param mixed $assembly = false] - сборка объекта, если передано его название
     * @param ...$args - аргументы создания контроллера
     * 
     * @throws \Exception - выбрасывает исключение при неверном типе имени объекта
     */
    public function __construct ($name, $assembly = false, ...$args)
    {
        if (is_int ($name))
            $this->selector = $name;

        elseif (is_string ($name))
            $this->selector = VoidCore::createObject ($name, $assembly,
                ...array_map ('Empathy\Engine\Additions::uncoupleSelector', $args));

        else throw new \Exception ('Incorrect NetObject name passed');
    }

    /**
     * Геттер свойств
     * 
     * @param string $name - имя свойства
     */
    public function __get (string $name)
    {
        if (method_exists ($this, $method = 'get_'. $name))
            try
            {
                return $this->$method ();
            }

            catch (\WinformsException $e) {}

        if (isset ($this->$name))
            return $this->$name;

        try
        {
            return Additions::coupleSelector ($this->getProperty ($name));
        }

        catch (\WinformsException $e)
        {
            return Additions::coupleSelector ($this->getField ($name));
        }
    }

    /**
     * Сеттер свойств
     * 
     * @param string $name - имя свойства
     * @param mixed $value - значение свойства
     */
    public function __set (string $name, $value): void
    {
        if (method_exists ($this, $method = 'set_'. $name))
            $this->$method ($value);
        
        else try
        {
            $this->setProperty ($name, Additions::uncoupleSelector ($value));
        }

        catch (\WinformsException $e)
        {
            try
            {
                $this->setField ($name, Additions::uncoupleSelector ($value));
            }

            catch (\WinformsException $t)
            {
                throw $e;
            }
        }
    }

    /**
     * Вызов метода
     * 
     * @param string $name - название метода
     * @param array $args  - массив аргументов вызова
     */
    public function __call (string $name, array $args)
    {
        return Additions::coupleSelector ($this->callMethod ($name,
            array_map ('Empathy\Engine\Additions::uncoupleSelector', $args)));
    }

    /**
     * Установка события
     * 
     * @param string $eventName - название события
     * @param string $eventClosure - коллбэк события
     */
    public function on (string $eventName, callable $eventClosure): self
    {
        Events::setEvent ($this->selector, $eventName, $eventClosure);

        return $this;
    }

    /**
     * Деструктор .NET объекта
     */
    public function dispose (): void
    {
        VoidCore::removeObjects ($this->selector);
    }

    /**
     * Преобразование текущего объекта из .NET массива в массив PHP
     */
    protected function get_list ()
    {
        try
        {
            $size = $this->count;
        }

        catch (\WinformsException $e)
        {
            $size = $this->length;
        }

        $list = [];
        
        for ($i = 0; $i < $size; ++$i)
            $list[] = Additions::coupleSelector (VoidCore::getArrayValue ($this->selector, $i));
        
        return $list;
    }

    # ArrayAccess interface

    public function offsetExists ($offset): bool
    {
        try
        {
            VoidCore::getArrayValue ($this->selector, $offset);
        }

        catch (\WinformsException $e)
        {
            return false;
        }

        return true;
    }

    public function offsetGet ($offset)
    {
        return Additions::coupleSelector (VoidCore::getArrayValue ($this->selector, $offset));
    }

    public function offsetSet ($offset, $value): void
    {
        if ($offset === null)
            try
            {
                $offset = $this->count;
            }

            catch (\WinformsException $e)
            {
                $offset = $this->length;
            }

        VoidCore::setArrayValue ($this->selector, $offset, Additions::uncoupleSelector ($value));
    }

    public function offsetUnset ($offset): void
    {
        $this->callMethod ('RemoveAt', $offset);
    }

    # VoidCore methods wrappers

    protected function getProperty ($name)
    {
        return VoidCore::getProperty ($this->selector, $name);
    }

    protected function setProperty (string $name, $value): void
    {
        VoidCore::setProperty ($this->selector, $name, $value);
    }

    protected function getField ($name)
    {
        return VoidCore::getField ($this->selector, $name);
    }

    protected function setField (string $name, $value): void
    {
        VoidCore::setField ($this->selector, $name, $value);
    }

    protected function callMethod (string $name, array $args = [])
    {
        return VoidCore::callMethod ($this->selector, $name, ...$args);
    }
}

/**
 * Контроллер .NET класса
 */
class NetClass extends NetObject
{
    /**
     * Конструктор контроллера
     * 
     * @param mixed $name - указатель на .NET класс или его имя
     * [@param mixed $assembly = false] - сборка класса, если передано его название
     * 
     * @throws \Exception - выбрасывает исключение при неверном типе имени класса
     */
    public function __construct ($name, $assembly = false)
    {
        if (is_int ($name))
            $this->selector = $name;

        elseif (is_string ($name))
            $this->selector = VoidCore::getClass ($name, $assembly);

        else throw new \Exception ('Incorrect NetClass name passed');
    }
}
