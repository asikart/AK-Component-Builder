<?php
/**
 * @package     AKHelper
 * @subpackage  main
 *
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */


// No direct access
defined('_JEXEC') or die;


class AKQuery {
	
	public static function publishDate ( $prefix = '' ) {
		$db = JFactory::getDBO();
		$nowDate 	= JFactory::getDate()->toMySQL();
        $nullDate	= $db->getNullDate();
        
        $date_where = " ( {$prefix}publish_up < '{$nowDate}' OR  {$prefix}publish_up = '{$nullDate}') AND ".
        			  "( {$prefix}publish_down > '{$nowDate}' OR  {$prefix}publish_down = '{$nullDate}') " ;
        			  
        return $date_where ;
	}
	
	public static function publishedContent ( $prefix = '' ) {
		return self::publishDate($prefix)." AND {$prefix}state >= '1' ";
	}
	
	public static function massId ( $ids = array() , $logic = 'AND' , $type = 'id' ) {
		if( !is_array($ids) ) $ids = explode( ',' , $ids );
		
		$temp = array();
		foreach ($ids as $id)
	        	$temp[] = " {$type} = '{$id}' ";
		
		$where = " ( ".implode( $logic ,$temp)." ) " ;
		return $where;
	}
}



