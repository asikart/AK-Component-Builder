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
class {COMPONENT_NAME_UCFIRST}HelperDb
{
	public static function getSelectList( $table_array = array() , $all = true )
	{
		$db = JFactory::getDbo();
		$tables = $db->getTableFields( $table_array );
		$select = array();
		$fields = array() ;
		$i = 'a' ;
		
		foreach( $tables as $table ){
			if($all)
				$select[] = "{$i}.*" ;
			
			foreach( $table as $key=>$var ){
				$fields[] = "{$i}.{$key} AS {$i}_{$key}" ;
			}
			
			$i = ord($i);
			$i ++ ;
			$i = chr($i) ;
		}
		
		return $final = implode( "," , $select ).",\n".implode( ",\n" , $fields );
	}
	
	public static function mergeFilterFields( $filter_fields , $tables = array() )
	{
		$db = JFactory::getDbo();
		$tables = $db->getTableFields( $tables );
		$fields = array() ;
		$i = 'a' ;
		
		foreach( $tables as $table ){

			foreach( $table as $key=>$var ){
				$fields[] = "{$i}.{$key}" ;
				$fields[] = $key ;
			}
			
			$i = ord($i);
			$i ++ ;
			$i = chr($i) ;
		}
		
		return array_merge( $filter_fields , $fields );
	}
}
