<?php
/**
 * @version     1.0.0
 * @package     com_{COMPONENT_NAME}
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */

// No direct access
defined('_JEXEC') or die;

class AKText
{
	
	static function __callStatic($name, $args)
	{
		$args[0] = strtoupper( 'COM_{COMPONENT_NAME_UC}_'.$args[0] );
		
		return call_user_func_array( array( 'JText' , $name ) , $args );
	}
}
