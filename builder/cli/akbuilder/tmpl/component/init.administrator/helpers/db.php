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
	public static function getSelectList( $tables = array() , $all = true )
	{
		$db = JFactory::getDbo();
		
		$select = array() ;
		$fields = array() ;
		$i = 'a' ;
		
		foreach( $tables as $k => $table ){
			
			$columns = $db->getTableColumns( $table );
			
			if($all){
				$select[] = "{$k}.*" ;
			}
			
			foreach( $columns as $key=>$var ){
				$fields[] = "{$k}.{$key} AS {$k}_{$key}" ;
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
		$fields = array() ;
		$i = 'a' ;
		
		$ignore = array(
			'params'
		) ;
		
		foreach( $tables as $k => $table ){
			
			$columns = $db->getTableColumns( $table );
			
			foreach( $columns as $key=>$var ){
				if( in_array($key, $ignore) ){
					continue;
				}
				
				$fields[] = "{$k}.{$key}" ;
				$fields[] = $key ;
			}
			
			$i = ord($i);
			$i ++ ;
			$i = chr($i) ;
		}
		
		return array_merge( $filter_fields , $fields );
	}
}
