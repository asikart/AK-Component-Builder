<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_{COMPONENT_NAME}
 *
 * @copyright   Copyright (C) 2012 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Generated by AKHelper - http://asikart.com
 */

// no direct access
defined('_JEXEC') or die;

class AKText
{
	
	static function __callStatic($name, $args)
	{
		$args[0] = strtoupper( 'COM_{COMPONENT_NAME_UC}_'.$args[0] );
		
		return call_user_func_array( array( 'JText' , $name ) , $args );
	}
}
