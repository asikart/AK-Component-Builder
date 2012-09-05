<?php
/**
 * php document by Asika
 */ 

defined('_JEXEC') or die;

define( 'AKBUILDER_PATH' , __DIR__ ) ;

jimport( 'joomla.filesystem.file' );
jimport( 'joomla.filesystem.folder' );

class AKBuilder
{

	public static function getInstance($type = 'component', $name='com_custom', $client='administrator')
	{
		static $instance ;
		
		if( !isset( $instance[$type][$client] ) ) {
			include_once __DIR__.DS.'type'.DS.$type.'.php' ;
			$class_name = __CLASS__.ucfirst($type);
			$instance = new $class_name( $name, $client);
		}
		
		return $instance ;
	}
	
}