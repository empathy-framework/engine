<?php

namespace Empathy\Engine\Components;

use VoidCore;

use Empathy\Engine\{
    Components,
    Component
};

/**
 * Компонент "Процесс"
 */
class Process extends Component
{
	protected ?string $classname = 'System.Diagnostics.Process';
	protected ?string $assembly  = 'System';

    /**
     * Конструктор
     * 
     * [@param int $pid = null] - PID процесса
     */
	public function __construct (int $pid = null)
	{
        $this->selector = VoidCore::getClass ($this->classname, $this->assembly);

		if ($pid !== null)
            $this->selector = $pid == getmypid () ?
                VoidCore::callMethod ($this->selector, 'GetCurrentProcess') :
                VoidCore::callMethod ($this->selector, 'GetProcessById', $pid);

		Components::add ($this);
	}
    
    /**
     * Получить экземпляр процесса по PID
     * 
     * @param int $pid
     * 
     * @return Process
     */
	public static function getProcessById (int $pid): Process
	{
		return new Process ($pid);
	}
    
    /**
     * Получить экземпляр текущего процесса
     */
	public static function getCurrentProcess (): Process
	{
		return new Process (getmypid ());
	}
}
