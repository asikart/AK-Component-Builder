<?php
/**
 * @version     1.0.0
 * @package     com_fbimporter
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by AKHelper - http://asikart.com
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Fbimporter helper.
 */
class {COMPONENT_NAME_UCFIRST}HelperVersion
{
	
	protected static $version ;
	
	protected static $plugins ;
	
	/*
	 * function get
	 * @param 
	 */
	
	public static function get($version)
	{
		if(!empty(self::$version[$version])){
			return true ;
		}
		
		return false ;
	}
	
	/*
	 * function detectVersion
	 * @param 
	 */
	
	public static function detectVersion()
	{
		jimport('joomla.filesystem.folder');
		$versions = JFolder::folders(JPATH_COMPONENT_ADMINISTRATOR.'/class/version');
		
		if(!$versions){
			$versions = array();
		}
		
		foreach( $versions as $version ):
			self::attachPlugin($version);
		endforeach;
	}
	
	/*
	 * function attachProPlugin
	 * @param 
	 */
	
	public static function attachPlugin($version)
	{
		$app 	= JFactory::getApplication() ;
		$path 	= JPATH_COMPONENT_ADMINISTRATOR . "/class/version/{$version}/{$version}.php" ;
		$config['params'] = JComponentHelper::getParams('com_{COMPONENT_NAME}') ;
		
		if(JFile::exists($path)){
			include_once $path ;
			$dispatcher = JDispatcher::getInstance();
			
			$class_name = 'plg{COMPONENT_NAME_UCFIRST}'.ucfirst($version) ;
			
			if(class_exists($class_name)){
			
				$plugin = new $class_name($dispatcher, $config);
				$dispatcher->attach($plugin);
				
				self::$plugins[$version] = $plugin;
				self::$version[$version] = true ;
				
				return true ;
			}else{
				return false ;
			}
			
		}else{
			return false ;
		}
		
	}
	
}
