<?php

/**
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * @package     Empathy Engine
 * @copyright   2020 Podvirnyy Nikita (Observer KRypt0n_)
 * @license     GNU GPL-3.0 <https://www.gnu.org/licenses/gpl-3.0.html>
 * @author      Podvirnyy Nikita (Observer KRypt0n_)
 * 
 * Contacts:
 *
 * Email: <suimin.tu.mu.ga.mi@gmail.com>
 * VK:    <https://vk.com/technomindlp>
 *        <https://vk.com/hphp_convertation>
 * 
 */

namespace Empathy;

const ENGINE_DIR = __DIR__;

chdir (__DIR__);

require 'common/Additions.php';
require 'common/CoreWrappers.php';
require 'common/Others.php';
require 'common/Events.php';
require 'common/Async.php';

require 'extend/common/Globals.php';
require 'extend/common/Others.php';
require 'extend/common/Constants.php';
require 'extend/common/Components.php';
require 'extend/components/Component.php';
require 'extend/components/Control.php';

foreach (glob ('extend/components/*/*.php') as $name)
    require $name;
