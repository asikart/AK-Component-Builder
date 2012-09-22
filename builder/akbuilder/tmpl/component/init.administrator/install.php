<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * Script file of HelloWorld component
 */
class com_{COMPONENT_NAME_UCFIRST}InstallerScript
{
	/**
	 * method to install the component
	 *
	 * @return void
	 */
	function install($parent) 
	{
		
		
	}
 
	/**
	 * method to uninstall the component
	 *
	 * @return void
	 */
	function uninstall($parent) 
	{
		
	}
 
	/**
	 * method to update the component
	 *
	 * @return void
	 */
	function update($parent) 
	{
		
	}
 
	/**
	 * method to run before an install/update/uninstall method
	 *
	 * @return void
	 */
	function preflight($type, $parent) 
	{
		
	}
 
	/**
	 * method to run after an install/update/uninstall method
	 *
	 * @return void
	 */
	function postflight($type, $parent) 
	{
		
		$db = JFactory::getDbo();
		
		// Get install manifest
		// ========================================================================
		$p_installer 	= $parent->getParent() ;
		$installer 		= new JInstaller();
		$manifest 		= $p_installer->manifest ;
		$path 			= $p_installer->getPath('source');
		$result			= array() ;
		
		
		
		// Install modules
		// ========================================================================
		$modules 	= $manifest->modules ;
		
		if(!empty($modules)){
			foreach( (array)$modules as $module ):
				
				if(!trim($module)) continue ;
				
				$module = is_array($module) ? $module : array($module) ;
				
				// Install per module
				foreach( $module as $var ):
					$install_path = $path.'/../modules/'.$var ;
					$result[] = $installer->install($install_path);
				endforeach;
				
			endforeach;
		}
		
		
		
		// Install plugins
		// ========================================================================
		$plugins 	= $manifest->plugins ;
		
		if(!empty($plugins)){
			foreach( (array)$plugins as $plugin ):
				
				if(!trim($plugin)) continue ;
				
				$plugin = is_array($plugin) ? $plugin : array($plugin) ;
				
				// Install per module
				foreach( $plugin as $var ):
					$install_path = $path.'/../plugins/'.$var ;
					
					if( $result[] = $installer->install($install_path) ){
						// Enable this plugin
						$q = $db->getQuery(true) ;
						
						$plg_name 	= explode('/', $var) ;
						$plg_name 	= array_pop($plg_name) ;
						$plg_group 	= $installer->manifest->getAttribute('group') ;
						
						$q->update('#__extensions')
							->set("enabled = 1")
							->where("type = 'plugin'")
							->where("element = '{$plg_name}'")
							->where("folder = '{$plg_group}'")
							;
						
						$db->setQuery($q);
						$db->query();
					}
					
				endforeach;
				
			endforeach;
		}
		
	}
	
}