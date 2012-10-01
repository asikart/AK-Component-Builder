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

/**
 * {COMPONENT_NAME_UCFIRST} helper.
 */
class {COMPONENT_NAME_UCFIRST}HelperLoader
{
	
	public static $files = array() ;
	
	/*
	 * function import
	 * @param $uri
	 */
	
	public static function import($uri)
	{
		$key = $uri ;
		if( isset(self::$files[$key]) ){
			return true ;
		}
		
		$uri = explode( '://' , $uri ) ;
		
		switch($uri[0]){
			
			case 'admin' :
				$root = JPATH_COMPONENT_ADMINISTRATOR ;
				break ;
			
			case 'site' :
				$root = JPATH_COMPONENT_SELF ;
				break ;
			
			default :
				$root = JPATH_COMPONENT ;
				break ;
		}
		
		$path = $root.'/'.$uri[1].'.php' ;
		
		if( JFile::exists($path) ){
			include_once $path ;
			self::$files[$key] = $path ;
			return true ;
		}else{
			return false ;
		}
	}
}