<?php
/**
 * Part of Windwalker project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

include_once JPATH_LIBRARIES . '/windwalker/Windwalker/init.php';

JLoader::registerPrefix('{COMPONENT_NAME_UCFIRST}', JPATH_COMPONENT);
JLoader::registerNamespace('{COMPONENT_NAME_UCFIRST}', JPATH_COMPONENT_ADMINISTRATOR . '/src');
JLoader::register('{COMPONENT_NAME_UCFIRST}Component', JPATH_COMPONENT . '/component.php');

echo with(new {COMPONENT_NAME_UCFIRST}Component)->execute();
