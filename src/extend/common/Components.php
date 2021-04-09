<?php

namespace Empathy\Engine;

use Empathy\Engine\Wrappers\NetObject;

/**
 * Менеджер компонентов
 */
class Components
{
    protected static array $objects = []; // Список слабых ссылок на объекты

    /**
     * Добавление компонента
     * 
     * @param NetObject $object - компонент
     */
    public static function add (NetObject $object): void
    {
        self::$objects[$object->selector] = \WeakReference::create ($object);
    }

    /**
     * Получение компонента по указателю
     * 
     * @param int $selector - указатель компонента
     * 
     * @return NetObject|null - возвращает экземпляр компонента или null если его не существует
     */
    public static function get (int $selector): ?NetObject
    {
        if (!isset (self::$objects[$selector]))
            return null;
        
        $object = self::$objects[$selector]->get ();

        if ($object === null)
            self::remove ($selector);

        return $object;
    }

    /**
     * Проверить компонент на существование
     * 
     * @param int $selector - указатель на компонент
     * 
     * @return bool
     */
    public static function exists (int $selector): bool
    {
        return isset (self::$objects[$selector]);
    }

    /**
     * Получить список всех слабых ссылок на компоненты
     * 
     * @return array
     */
    public static function getObjects (): array
    {
        return self::$objects;
    }

    /**
     * Удалить компонент из менеджера
     * 
     * @param int $selector - указатель на компонент
     */
    public static function remove (int $selector): void
    {
        unset (self::$objects[$selector]);
    }

    /**
     * Очистить менеджер от удалённых компонентов
     */
    public static function clear (): void
    {
        foreach (self::$objects as $selector => $reference)
            if ($reference->get () === null)
                unset (self::$objects[$selector]);
    }
}

/**
 * Алиас Components::get
 */
function _c (int $selector): ?NetObject
{
    return Components::get ($selector);
}

// TODO: поддержка многоуровневых ссылок вида родитель->родитель->объект
// VoidCore::getPrevClass

/**
 * Получить экземпляр компонента по его имени
 * 
 * @param string $name - имя компонента
 * 
 * @return NetObject|null - возвращает экземпляр компонента или null в случае неудачи
 */
function c (string $name): ?NetObject
{
    if (is_int ($name) && ($object = _c($name)) !== null)
        return $object;

    foreach (Components::getObjects () as $selector => $reference)
    {
        $object = $reference->get ();

        if ($object === null)
            continue;

        try
        {
            if ($object->name == $name)
                return $object;
        }

        catch (\Throwable $e)
        {
            continue;
        }
    }

    return null;
}
