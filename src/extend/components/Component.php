<?php

namespace Empathy\Engine;

use VoidCore;
use Empathy\Engine\Wrappers\NetObject;

/**
 * Базовый класс реализации обёртки .NET компонента
 */
abstract class Component extends NetObject
{
    public $helpStorage; // Дополнительное личное хранилище компонента (для записей пользователя)

    protected ?string $classname; // .NET класс компонента
    protected ?string $assembly; // Сборка компонента

    /**
     * Конструктор компонента
     * 
     * @param ...$args - аргументы создания объекта
     */
    public function __construct (...$args)
    {
        parent::__construct ($this->classname, $this->assembly, ...$args);

        Components::add ($this);
    }

    /**
     * Удаление компонента
     */
    public function dispose (): void
    {
        VoidCore::removeObjects ($this->selector);
        Components::remove ($this->selector);
    }

    /**
     * Деструктор (компонент будет автоматически удалён если он больше не используется)
     */
    public function __destruct ()
    {
        if (VoidCore::destructObject ($this->selector))
            $this->dispose ();
    }
}
