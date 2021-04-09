<?php

namespace Empathy\Engine;

use VoidCore;

use Empathy\Engine\Wrappers\{
    NetObject,
    NetClass
};

/**
 * Класс реализации дополнительного функционала
 */
class Additions
{
    /**
     * Обёртка указателя на объект в экземпляр NetObject
     */
    public static function coupleSelector ($selector)
    {
        return is_int ($selector) && VoidCore::objectExists ($selector) ?
            new NetObject ($selector) : $selector;
    }

    /**
     * Свёртывание экземпляров NetObject и массивов в указатель на соответствующий им .NET объект
     */
    public static function uncoupleSelector ($object)
    {
        if (is_object ($object) && $object instanceof NetObject)
            return $object->selector;

        elseif (is_array ($object))
        {
            $array = dn ($object);

            return $array === null ?
                $object : $array->selector;
        }

        return $object;
    }
}

/**
 * Функция упрощения создания экземпляров NetObject, NetClass и .NET массивов
 */
function dn (...$args): ?NetObject
{
    if (sizeof ($args) == 0)
        return null;
    
    if (sizeof ($args) == 2 && is_string ($args[0]) && is_array ($args[1]))
    {
        $array = (new NetClass ('System.Array'))
            ->createInstance (VoidCore::typeof ($args[0]), $size = sizeof ($args[1]));

        for ($i = 0; $i < $size; ++$i)
            $array[$i] = array_shift ($args[1]);
        
        return $array;
    }

    elseif (sizeof ($args) == 1 && is_array ($args[0]))
    {
        if (sizeof ($args[0]) == 0)
            return null;
        
        $item = current ($args[0]);

        if ($item instanceof NetObject)
            return dn ($item->getType ()->toString (), $args[0]);

        elseif (is_int ($item) && VoidCore::objectExists ($item))
            return dn (VoidCore::callMethod (VoidCore::callMethod ($item, 'GetType'), 'ToString'), array_map (fn ($item) => $item->selector, $args[0]));

        else
        {
            $type = gettype ($item);

            if ($type == 'string')
                return dn ('System.String', $args[0]);

            elseif ($type == 'integer')
                return dn ('System.Int32', $args[0]);

            elseif ($type == 'double')
                return dn ('System.Double', $args[0]);

            elseif ($type == 'boolean')
                return dn ('System.Boolean', $args[0]);
            
            return null;
        }
    }

    else try
    {
        $object = new NetObject (...$args);
    }

    catch (\WinformsException $e)
    {
        if (VoidCore::callMethod ($e->getNetException (), 'ToString') == 'System.MemberAccessException')
            throw $e;
        
        $object = new NetClass (...$args);
    }

    return $object;
}

/**
 * Функция получения enum
 * 
 * @param string $baseType - название enum
 * @param string $value - значение enum
 * 
 * @return int - возвращает значение enum
 */
function enum (string $baseType, string $value): int
{
    try
    {
        return VoidCore::callMethod (VoidCore::getClass ('System.Enum'), ['parse', VC_OBJECT], VoidCore::typeof ($baseType), $value, true);
    }

    catch (\WinformsException $e)
    {
        return (new NetClass ($baseType))->$value;
    }
}

/**
 * Подключение .NET библиотеки
 * 
 * @param string $path - путь до библиотеки
 * 
 * @return bool - возвращает статус подключения
 */
function loadModule (string $path): bool
{
    try
    {
        (new NetClass ('System.Reflection.Assembly', 'mscorlib'))->loadFrom ($path);
    }

    catch (\WinformsException $e)
    {
        return false;
    }

    return true;
}
